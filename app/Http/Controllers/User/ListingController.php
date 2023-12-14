<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\Listing;
use App\Models\Level;
use App\Models\Category;
use App\Models\Language;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExtraImage;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
	use Upload,Notify;

	public $user, $theme;

	public function __construct()
	{
		$this->middleware(['auth']);
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
			return $next($request);
		});
		$this->theme = template();
	}


    public function listingList(){
		$listings = Listing::where('user_id', $this->user->id)->latest()->paginate(config('basic.paginate'));
		return view($this->theme . 'user.listing.list', compact('listings'));
	}

    public function listingCreate(){
		$categories = Category::with('details')->latest()->get();
		return view($this->theme . 'user.listing.create', compact('categories'));
	}

	public function listingStore(Request $request){

		$req = Purify::clean($request->except('image', 'listing-image' ,'_token', '_method'));
		$purifiedData['listing_image'] = $request->listing_image ?? null;
		$req['image'] = $request->image ?? null;
		$req['listing_image'] = $request->listing_image ?? null;
		$rules = [
			'title' => 'required|max:100',
			'category_id' => 'required|integer|exists:categories,id',
			'tag' => 'required',
			'description' => 'required',
			'extra_title.*' => 'nullable|string|max:255',
			'extra_price.*' => 'nullable|numeric|min:0',
			'faq_title.*' => 'required_with:faq_description|string|max:255',
			'faq_description.*' => 'required_with:faq_title|string|max:2000',
			'requirementsQues.*' => 'required|string|max:300',
		];
		$message = [
			'title.required' => 'Title field is required',
			'title.max' => 'Title field may not be greater than :max characters.',
			'category_id.required' => 'Category field is required',
			'tag.required' => 'Tag field is required',
			'description.required' => 'Description field is required',
			'requirementsQues.required' => 'Requirement Question field is required',
			'requirementsQues.max' => 'Requirement Ques field may not be greater than :max characters.',

		];
		$validator = Validator::make($req, $rules, $message);
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		$packages = [];
		if($request->package_name)
		{
			for ($i = 0; $i<count($request->package_name);$i++)
			{
				$packages[$i]['package_name'] 	= $request->package_name[$i] ?? 'abc';
				$packages[$i]['revision'] 		= $request->revision[$i] ?? '0';
				$packages[$i]['delivery'] 		= $request->delivery[$i] ?? '0';
				$packages[$i]['package_price'] 	= $request->delivery[$i] ?? '0';
				$packages[$i]['package_price'] 	= $request->package_price[$i]??'0';
				$packages[$i]['package_desc'] 	= $request->package_desc[$i]??'';
			}
		}
		$extra_services = [];
		if ($request->extra_title) {
			for ($i = 0; $i < count($request->extra_title); $i++) {
				$extra_services[$i]['extra_title'] = $request->extra_title[$i] ?? 'abc';
				$extra_services[$i]['extra_price'] = $request->extra_price[$i] ?? 0;
			}
		}
		$faqs = [];
		if ($request->faq_title) {
			for ($i = 0; $i < count($request->faq_title); $i++) {
				$faqs[$i]['faq_title'] = $request->faq_title[$i] ?? 'abc';
				$faqs[$i]['faq_description'] = $request->faq_description[$i] ?? 0;
			}
		}

		$requirementsQuestion = [];
		if ($request->requirementsQues) {
			for ($i = 0; $i < count($request->requirementsQues); $i++) {
				$requirementsQuestion[$i]['requirementsQues'] = $request->requirementsQues[$i] ?? 'abc';
			}
		}
			$listings = new Listing();
			$listings->user_id = $this->user->id;
			$listings->category_id = $req['category_id'];
			$listings->sub_category_id = $req['subCategory_id'];
			$listings->title = $req['title'];
			$listings->tag = $req['tag'];
			$listings->description = $req['description'];
			$listings->package = $packages ?? [] ;
			$listings->extra_services = $extra_services ?? [];
			$listings->faqs = $faqs ?? [];
			$listings->requirement_ques = $requirementsQuestion ?? [];
			if ($request->image) {

				try {
					$image = $this->fileUpload($request->image, config('location.listing.path'),null);

					if ($image) {
						$listings->image = $image['path'] ?? null;
						$listings->driver = $image['driver'] ?? null;
					}
				} catch (\Exception $e) {
					return back()->with('alert', 'Image could not be uploaded');
				}
			}
			$listings->status = 0;
			$listings->save();
			if ($request->hasFile("listing_image") && $request->file("listing_image")) {
				foreach ($request->listing_image as $key => $images) {

					try {
						$listingImage = new ExtraImage();
						$listingImage->listing_id = $listings->id;

						$image = $this->fileUpload($images,config('location.listing.path'),  $listingImage->driver);

						if ($image) {
							$listingImage->extra_image = $image['path'];
							$listingImage->driver = $image['driver'];
						}
						$listingImage->save();


					} catch (\Exception $exp) {
						continue;
					}
				}
			}
		$msg = [
			'influencer_name' => $this->user->username,
			'title' => $req['title'],
		];
		$adminAction = [
			"link" => route('admin.listing.list'),
			"icon" => "fas fa-user text-white"
		];
		$this->adminPushNotification('LISTING_CREATE', $msg, $adminAction);
		$this->adminFirebasePushNotification('LISTING_CREATE',$msg,$adminAction);

		return redirect()->route('user.listing.list')->with('success', 'Listing Saved Successfully.');
	}

	public function listingDetails($slug, $id)
	{
		if (Auth::check()) {
			$data['listingDetails'] = Listing::with('extraImages', 'category', 'subCategory', 'user.profile.getCountry','review')->where('status', '1')->where('id', $id)->first();

			if ($data['listingDetails']) {
				$data['recommendedListings'] = $data['listingDetails']->id;

				$query = Listing::where('user_id', $data['listingDetails']->user_id)->where('id', '!=', $data['recommendedListings'])->with('review')->limit(2);
				$data['recommendedLists'] = $query->get();
				$data['recommendedCount'] = $query->count();
				$user = $data['listingDetails']->user;

				$data['levels'] = Level::with('details')->get();
				$data['reviews'] = Review::where('listing_id',$id)->with('reviewer','influencer')->latest()->get();

				return view($this->theme . 'user.listing.listing-details', $data);
			} else {
				return back()->with('error', 'Listing details is not available.');
			}
		} else {
			return redirect()->route('login')->with('error', 'Please At First Login To Your Account');
		}
	}

	public function isHelpful(Request $request)
	{
		$review = Review::findOrFail($request->review_id);
		$review->is_helpful = $request->is_helpful;
		$review->save();
		return response()->json($review);
	}

	public function listingEdit($id)
	{
		$data['listing'] = Listing::findOrFail($id);
		$categories = Category::with('details')->latest()->get();
		return view($this->theme.'user.listing.edit',$data,compact('categories'));
	}

	public function listingUpdate(Request $request,$id)
	{
		$req = Purify::clean($request->except('image', 'listing-image' ,'_token', '_method'));
		$purifiedData['listing_image'] = $request->listing_image ?? null;
		$req['image'] = $request->image ?? null;
		$req['listing_image'] = $request->listing_image ?? null;
		$rules = [
			'title' => 'required|max:100',
			'category_id' => 'required|integer|exists:categories,id',
			'tag' => 'required',
			'description' => 'required',
			'extra_title.*' => 'nullable|string|max:255',
			'extra_price.*' => 'nullable|numeric|min:0',
			'faq_title.*' => 'required_with:faq_description|string|max:255',
			'faq_description.*' => 'required_with:faq_title|string|max:2000',
			'requirementsQues.*' => 'required|string|max:300',
		];
		$message = [
			'title.required' => 'Title field is required',
			'title.max' => 'Title field may not be greater than :max characters.',
			'category_id.required' => 'Category field is required',

			'tag.required' => 'Tag field is required',
			'description.required' => 'Description field is required',
			'requirementsQues.required' => 'Requirement Question field is required',
			'requirementsQues.max' => 'Requirement Ques field may not be greater than :max characters.',

		];
		$validator = Validator::make($req, $rules, $message);
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}
		$packages = [];
		if($request->package_name)
		{
			for ($i = 0; $i<count($request->package_name);$i++)
			{
				$packages[$i]['package_name'] = $request->package_name[$i] ?? 'abc';
				$packages[$i]['revision'] = $request->revision[$i] ?? '0';
				$packages[$i]['delivery'] = $request->delivery[$i] ?? '0';
				$packages[$i]['package_price'] = $request->package_price[$i]??'0';
				$packages[$i]['package_desc'] = $request->package_desc[$i]??'';
			}
		}
		$extra_services = [];
		if ($request->extra_title) {
			for ($i = 0; $i < count($request->extra_title); $i++) {
				$extra_services[$i]['extra_title'] = $request->extra_title[$i] ?? 'abc';
				$extra_services[$i]['extra_price'] = $request->extra_price[$i] ?? 0;
			}
		}

		$faqs = [];
		if ($request->faq_title) {
			for ($i = 0; $i < count($request->faq_title); $i++) {
				$faqs[$i]['faq_title'] = $request->faq_title[$i] ?? 'abc';
				$faqs[$i]['faq_description'] = $request->faq_description[$i] ?? 0;
			}
		}

		$requirementsQuestion = [];
		if ($request->requirementsQues) {
			for ($i = 0; $i < count($request->requirementsQues); $i++) {
				$requirementsQuestion[$i]['requirementsQues'] = $request->requirementsQues[$i] ?? 'abc';
			}
		}

		$listings = Listing::findOrFail($id);
		$listings->user_id = $this->user->id;
		$listings->category_id = $req['category_id'];
		$listings->sub_category_id = $req['subCategory_id'];
		$listings->title = $req['title'];
		$listings->tag = $req['tag'];
		$listings->description = $req['description'];
		$listings->package = $packages ?? [] ;
		$listings->extra_services = $extra_services ?? [];
		$listings->faqs = $faqs ?? [];
		$listings->requirement_ques = $requirementsQuestion ?? [];
		if ($request->image) {

			try {
				$image = $this->fileUpload($request->image, config('location.listing.path'),null);

				if ($image) {
					$listings->image = $image['path'] ?? null;
					$listings->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'Image could not be uploaded');
			}
		}
		$listings->status = $listings->status??0;
		$listings->save();

		if ($request->hasFile("listing_image") && $request->file("listing_image")) {
			foreach ($request->listing_image as $key => $images) {

				try {
					$listingImage = new ExtraImage();
					$listingImage->listing_id = $listings->id;

					$image = $this->fileUpload($images,config('location.listing.path'),  $listingImage->driver);

					if ($image) {
						$listingImage->extra_image = $image['path'];
						$listingImage->driver = $image['driver'];
					}
					$listingImage->save();

				} catch (\Exception $exp) {
					continue;
				}
			}
		}

		return redirect()->route('user.listing.list')->with('success', 'Listing updated successfully.');

	}

	public function getSubCategory(Request $request)
    {
		$language = Language::where('short_name', session()->get('lang'))->first();

        $sub_category = SubCategory::with('details')->where('category_id', $request->category)
						->whereHas('details', function ($q) use ($language){
							$q->groupBy('language_id')
							->where('language_id', $language->id);
						})
						->get();

		if(count($sub_category) > 0)
        {
			return response()->json($sub_category);
        }
        else{
			return response()->json(['error' => "Sub-Category not available under this Category"]);
        }
    }

	public function listingDelete($id)
    {
        $data = Listing::where('user_id', $this->user->id)->findOrFail($id);
		$dataImage = $this->fileDelete($data->driver, $data->image);

		$dataExtraImages = ExtraImage::where('listing_id', $data->id)->get();
		if ($dataExtraImages) {
			foreach ($dataExtraImages as $key => $images) {
				$relatedImageToDelete = ExtraImage::where('id', $images->id)->first();
				if ($relatedImageToDelete) {
					$imageDelete = $this->fileDelete($relatedImageToDelete->driver, $relatedImageToDelete->extra_image);
				}
			}
		}
        $data->delete();
        return redirect()->route('user.listing.list')->with('success', 'Listing has been deleted');
    }

	public function order()
	{
		return view($this->theme.'user.order.listing_order');
	}

}
