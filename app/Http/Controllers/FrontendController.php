<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\SocialLink;
use App\Models\Testimonial;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\Content;
use App\Models\Language;
use App\Models\Template;
use App\Models\Subscribe;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use App\Models\BlogCategoryDetails;
use App\Models\Listing;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
	use Notify, Upload;

	public $theme, $user;

	public function __construct()
	{
		$this->theme = template();
		$this->user = auth()->user();
	}

	public function home()
	{
		$templateSection = ['hero', 'experience', 'about-us', 'how-it-work', 'testimonial', 'feature', 'blog'];
		$data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

		$contentSection = ['how-it-work', 'testimonial', 'feature', 'blog'];
		$data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
			->whereHas('content', function ($query) use ($contentSection) {
				return $query->whereIn('name', $contentSection);
			})
			->with(['content:id,name',
				'content.contentMedia' => function ($q) {
					$q->select(['content_id', 'driver', 'description']);
				}])
			->get()->groupBy('content.name');

		$data['blogs'] = Blog::with('details', 'category.details')->latest()->get();

		return view($this->theme . 'home', $data);
	}

	public function influencers()
	{
		$data['influencers'] = User::where(['status'=>1, 'email_verification'=>1, 'sms_verification' =>1])->whereHas('profileInfo')->inRandomOrder()->limit(12)->paginate(config('basic.paginate'));
		return view($this->theme . 'influencers', $data);
	}

	public function influencerProfile($username)
	{
		$data['influencerProfile'] = User::with('profile', 'profileInfo', 'education', 'certification', 'follower', 'following')
			->where('username', $username)
			->where(['status'=>1, 'email_verification'=>1, 'sms_verification' =>1])
			->whereHas('profileInfo')
			->firstOrFail();

		$data['listings'] = Listing::with('extraImages', 'category', 'subCategory', 'user.profile.getCountry', 'review')->where('status', '1')->where('user_id', $data['influencerProfile']->id)->paginate(config('basic.paginate'));
		$data['order'] = Order::where('influencer_id', $data['influencerProfile']->id)->where('status', 3)->get();
		$data['totalOrders'] = count($data['order']);
		$deliveryTotalTime = 0;
		foreach ($data['order'] as $order) {
			$deliveryDate = strtotime($order->delivery_date);
			$submitDate = strtotime($order->submit_date);
			$timeDiff = $deliveryDate - $submitDate;
			$deliveryTotalTime += $timeDiff;
		}

		if ($data['totalOrders'] > 0) {
			$avgTimeInSeconds = $deliveryTotalTime / $data['totalOrders'];
			$avgTimeInHours = $avgTimeInSeconds / 3600;
			$referenceTimeHours = 24;
			$data['percentage'] = ($avgTimeInHours / $referenceTimeHours) * 100;
		}

		$data['socialLinks'] = SocialLink::where('user_id', $data['influencerProfile']->id)->get();
		return view($this->theme . 'user.influencer.profile', $data);

	}


	public function allListings(Request $request)
	{
		$data['listings'] = Listing::with('extraImages', 'category', 'subCategory', 'user', 'review')
			->where('status', '1')->whereHas('user',function ($query){
				$query->where('status',1);
			})
			->orderBy('total_sell','desc')
			->paginate(config('basic.paginate'));
		$data['categories'] = Category::with('details')->get();

		if ($request->ajax()) {
			$view = view($this->theme . 'listing_post', $data)->render();
			return response()->json(['html' => $view]);
		}
		return view($this->theme . 'listings', $data);
	}

	public function filterListing(Request $request)
	{
		$category_id = $request->category_id;
		$sort = $request->sort;

		if ($category_id) {
			$listings = Listing::with('category', 'subCategory', 'user', 'review')
				->where('status', 1)
				->whereHas('user',function ($query){
					$query->where('status',1);
				})
				->where('category_id', $category_id)
				->get()->map(function ($query) {
				$query->route = route('user.listing.details', [slug($query->title), $query->id]);
				$query->user_profile = route('user.profile', $query->user->username);
				$query->user_img = $query->user->profilePicture();
				$query->seller_type = $query->user->profile->seller_type;
				$query->firstValue = $query->firstPackage();
				$query->ratings = $query->review->avg('ratings') ?? 0;
				return $query;
			});
		}
		if ($sort) {
			$listings = Listing::with('user')->where('status', 1)->orderBy('total_sell', 'desc')->get()->map(function ($query) {
				$query->route = route('user.listing.details', [slug($query->title), $query->id]);
				$query->user_profile = route('user.profile', $query->user->username);
				$query->user_img = $query->user->profilePicture();
				$query->seller_type = $query->user->profile->seller_type;
				$query->firstValue = $query->firstPackage();
				$query->ratings = $query->review->avg('ratings') ?? 0;
				return $query;
			});
		}
		return $listings;
	}

	public function filterSubcategory(Request $request)
	{
		$subcategory_id = $request->subCategory_id;
		$listings = Listing::with('user')
			->whereHas('user',function ($q){
				$q->where('status',1);
			})
			->where('sub_category_id', $subcategory_id)->get()->map(function ($query) {
			$query->route = route('user.listing.details', [slug($query->title), $query->id]);
			$query->user_profile = route('user.profile', $query->user->username);
			$query->user_img = getFile(($query->user->profile)->driver, ($query->user->profile)->profile_picture);
			$query->firstValue = $query->firstPackage();
			return $query;
		});
		return $listings;
	}

	public function listingSort(Request $request)
	{
		if ($request->sort == 1) {
			$listings = Listing::where('status', 1)->with('user')->orderBy('total_sell', 'desc')->get()->map(function ($query) {
				$query->route = route('user.listing.details', [slug($query->title), $query->id]);
				$query->user_profile = route('user.profile', $query->user->username);
				$query->user_img = getFile(($query->user->profile)->driver, ($query->user->profile)->profile_picture);
				$query->seller_type = $query->user->profile->seller_type;
				$query->firstValue = $query->firstPackage();
				return $query;
			});
			return response()->json($listings);
		} elseif ($request->sort == 2) {
			$listings = Listing::where('status', 1)->orderBy('package', 'asc')->get();
			return $listings;
		}
	}

	public function blog()
	{
		$data['title'] = "Blog";
		$data['allBlogs'] = Blog::with('details', 'category.details')->latest()->paginate(6);
		$data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();
		return view($this->theme . 'blog', $data);
	}

	public function blogDetails($slug = 'blog-detials', $id)
	{
		$data['title'] = "Blog Details";
		$data['singleBlog'] = Blog::with('details')->findOrFail($id);
		$data['thisCategory'] = BlogCategoryDetails::where('blog_category_id', $data['singleBlog']->blog_category_id)->firstOrFail();
		$data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();
		$data['relatedBlogs'] = Blog::with(['details', 'category.details'])->where('id', '!=', $id)->latest()->get();
		return view($this->theme . 'blogDetails', $data);
	}


	public function CategoryWiseBlog($slug = 'category-wise-blog', $id)
	{
		$data['title'] = "Blog";
		$data['allBlogs'] = Blog::with(['details', 'category.details'])->where('blog_category_id', $id)->latest()->paginate(3);
		$data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();
		$data['recentBlogs'] = Blog::with(['details', 'category.details'])->latest()->take(3)->inRandomOrder()->get();
		return view($this->theme . 'blog', $data);
	}


	public function blogSearch(Request $request)
	{
		$data['title'] = "Blog";
		$search = $request->search;

		$data['blogCategory'] = BlogCategory::with('details')->withCount('blog')->latest()->get();
		$data['recentBlogs'] = Blog::with(['details', 'category.details'])->latest()->take(3)->inRandomOrder()->get();

		$data['allBlogs'] = Blog::with('details', 'category.details')
			->whereHas('category.details', function ($qq) use ($search) {
				$qq->where('name', 'Like', '%' . $search . '%');
			})
			->orWhereHas('details', function ($qq2) use ($search) {
				$qq2->where('title', 'Like', '%' . $search . '%');
				$qq2->orWhere('author', 'Like', '%' . $search . '%');
				$qq2->orWhere('details', 'Like', '%' . $search . '%');
			})
			->latest()->paginate(3);

		return view($this->theme . 'blog', $data);
	}


	public function faq()
	{
		$templateSection = ['faq'];
		$data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

		$contentSection = ['faq'];
		$data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
			->whereHas('content', function ($query) use ($contentSection) {
				return $query->whereIn('name', $contentSection);
			})
			->with(['content:id,name',
				'content.contentMedia' => function ($q) {
					$q->select(['content_id', 'description']);
				}])
			->get()->groupBy('content.name');

		$data['increment'] = 1;
		return view($this->theme . 'faq', $data);
	}

	public function contact()
	{
		$templateSection = ['contact'];
		$templates = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');
		$title = 'Contact Us';
		$contact = @$templates['contact'][0]->description;
		return view($this->theme . 'contact', compact('title', 'contact'));
	}
	public function contactSend(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:50',
			'email' => 'required|email|max:91',
			'subject' => 'required|max:100',
			'message' => 'required|max:1000',
		]);
		$requestData = Purify::clean($request->except('_token', '_method'));

		$basic = (object)config('basic');
		$basicEmail = $basic->sender_email;

		$name = $requestData['name'];
		$email_from = $requestData['email'];
		$subject = $requestData['subject'];
		$message = $requestData['message'] . "<br>Regards<br>" . $name;
		$from = $email_from;

		$headers = "From: <$from> \r\n";
		$headers .= "Reply-To: <$from> \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$to = $basicEmail;

		if (@mail($to, $subject, $message, $headers)) {
			// echo 'Your message has been sent.';
		} else {
			//echo 'There was a problem sending the email.';
		}

		return back()->with('success', 'Mail has been sent');
	}

	public function subscribe(Request $request)
	{
		$purifiedData = Purify::clean($request->all());
		$validationRules = [
			'email' => 'required|email|min:8|max:100|unique:subscribes',
		];
		$validate = Validator::make($purifiedData, $validationRules);
		if ($validate->fails()) {
			return redirect(url()->previous() . '#subscribe')->withErrors($validate);
		}
		$purifiedData = (object)$purifiedData;

		$subscribe = new Subscribe();
		$subscribe->email = $purifiedData->email;
		$subscribe->save();

		return redirect(url()->previous() . '#subscribe')->with('success', 'Subscribe successfully');
	}

	public function getLink($getLink = 'pages-name', $id)
	{
		$getData = Content::findOrFail($id);
		$contentSection = [$getData->name];
		$contentDetail = ContentDetails::select('id', 'content_id', 'description', 'created_at')
			->where('content_id', $getData->id)
			->whereHas('content', function ($query) use ($contentSection) {
				return $query->whereIn('name', $contentSection);
			})
			->with(['content:id,name',
				'content.contentMedia' => function ($q) {
					$q->select(['content_id', 'description']);
				}])
			->get()->groupBy('content.name');

		$title = @$contentDetail[$getData->name][0]->description->title;
		$description = @$contentDetail[$getData->name][0]->description->description;
		return view($this->theme . 'getLink', compact('contentDetail', 'title', 'description'));
	}

	public function getTemplate($template = null)
	{
		$contentDetail = Template::where('section_name', $template)->firstOrFail();
		$title = @$contentDetail->description->title;
		$description = @$contentDetail->description->description;
		return view($this->theme . 'getLink', compact('contentDetail', 'title', 'description'));
	}


	public function logoUpdate(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('admin.control_panel.logo');
		} elseif ($request->isMethod('post')) {

			if ($request->hasFile('logo')) {
				try {
					$old = 'logo.png';
					$image = $this->fileUpload($request->logo, config('location.logo.path'), config('basic.default_file_driver'), $old, $old);
					if ($image) {
						config(['basic.logo_image' => $image['path']]);
					}
				} catch (\Exception $exp) {
					return back()->with('error', 'Logo could not be uploaded.');
				}
			}
			if ($request->hasFile('footer_logo')) {
				try {
					$old = 'footer-logo.png';
					$image = $this->fileUpload($request->footer_logo, config('location.logo.path'), config('basic.default_file_driver'), $old, $old);
					if ($image) {
						config(['basic.footer_image' => $image['path']]);
					}
				} catch (\Exception $exp) {
					return back()->with('error', 'Footer Logo could not be uploaded.');
				}
			}
			if ($request->hasFile('admin_logo')) {
				try {
					$old = 'admin-logo.png';
					$image = $this->fileUpload($request->admin_logo, config('location.logo.path'), config('basic.default_file_driver'), $old, $old);
					if ($image) {
						config(['basic.admin_logo' => $image['path']]);
					}
				} catch (\Exception $exp) {
					return back()->with('error', 'Logo could not be uploaded.');
				}
			}
			if ($request->hasFile('favicon')) {
				try {
					$old = 'favicon.png';
					$image = $this->fileUpload($request->favicon, config('location.logo.path'), config('basic.default_file_driver'), $old, $old);
					if ($image) {
						config(['basic.favicon_image' => $image['path']]);
					}
				} catch (\Exception $exp) {
					return back()->with('error', 'Favicon could not be uploaded.');
				}
			}

			$fp = fopen(base_path() . '/config/basic.php', 'w');
			fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
			fclose($fp);

			Artisan::call('optimize:clear');
			return back()->with('success', 'Logo, favicon and breadcrumb has been updated.');
		}
	}
	public function seoUpdate(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.seo', compact('basicControl'));
		}
		elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$purifiedData['image'] = $request->image;
			$validator = Validator::make($purifiedData, [
				'meta_keywords' => 'nullable|string|min:1',
				'meta_description' => 'nullable|string|min:1',
				'social_title' => 'nullable|string|min:1',
				'social_description' => 'nullable|string|min:1',
				'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;
			$basicControl->meta_keywords = $purifiedData->meta_keywords;
			$basicControl->meta_description = $purifiedData->meta_description;
			$basicControl->social_title = $purifiedData->social_title;
			$basicControl->social_description = $purifiedData->social_description;
			$basicControl->save();

			if ($request->hasFile('image')) {
				try {
					$old = 'meta.png';
					$image = $this->fileUpload($request->image, config('location.logo.path'), config('basic.default_file_driver'), $old, $old);
					if ($image) {
						config(['basic.logo_meta' => $image['path']]);
					}
				} catch (\Exception $exp) {
					return back()->with('error', 'Meta image could not be uploaded.');
				}
			}

			$fp = fopen(base_path() . '/config/basic.php', 'w');
			fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
			fclose($fp);

			return back()->with('success', 'Seo has been updated.');
		}
	}


	public function setLanguage($code)
	{
		$language = Language::where('short_name', $code)->firstOrFail();
		if (!$language) $code = 'US';
		session()->put('lang', $code);
		session()->put('rtl', $language ? $language->rtl : 0);
		return back();
	}

	public function testimonialAccept($id)
	{
		$accept = Testimonial::findOrFail($id);
		$accept->is_accepted = 1;
		$accept->save();
		return view($this->theme . 'feedback_testimonial', compact('id'));
	}

	public function testimonialRating(Request $request, $id)
	{
		$review = Testimonial::findOrFail($id);
		$review->client_note = $request->note;
		$review->ratings = $request->rating;
		$review->save();
		return back()->with('success', 'Client review successfully');
	}

}
