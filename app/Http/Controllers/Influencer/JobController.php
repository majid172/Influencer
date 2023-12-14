<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\Messenger;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use http\QueryString;
use Illuminate\Http\Request;
use App\Models\CategoryDetails;
use App\Models\JobPost;
use App\Models\JobProposal;
use App\Models\ServiceFee;
use App\Models\Fund;
use App\Models\Duration;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Hire;
use App\Models\JobSave;
use App\Models\Scope;
use App\Models\Chat;
use App\Models\UserProfile;
use App\Models\Invitation;
use App\Models\DislikeReason;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Symfony\Component\VarDumper\Dumper\esc;
use Yajra\DataTables\DataTables;

class JobController extends Controller
{

	use Notify, Upload;

	public $theme, $user;

	public function __construct()
	{
		$this->theme = template();
	}

	public function jobs(Request $request)
	{

		$data['basicControl'] = basicControl();
		$data['catagorDetails'] = CategoryDetails::with('category')->get();

		$data['jobs'] = JobPost::where('status', 1)->latest()->with('user', 'hire')
							->whereHas('user',function ($query){
								$query->where('status',1);
		})->paginate(10);
		$data['job_count'] = $data['jobs']->count();

		$filteredJobs = $data['jobs']->filter(function ($job) {
			return $job->fixed_rate !== null;
		});

		$data['min'] = $filteredJobs->where('fixed_rate', '>', 0)->min('fixed_rate');
		$data['max'] = $filteredJobs->max('fixed_rate');

		$minRange = $data['min'];
		$maxRange = $data['max'];

		if ($request->has('my_range')) {
			$range = explode(';', $request->my_range);
			$minRange = $range[0];
			$maxRange = $range[1];
		}

		$data['job_types'] = Scope::firstOrFail();
		$data['dislike_reasons'] = DislikeReason::get();


		if ($request->ajax()) {
			$view = view($this->theme . 'job_post', $data)->render();
			return response()->json(['html' => $view]);
		}
		return view($this->theme . 'jobs', $data);
	}

	public function jobSearch(Request $request)
	{

		$search = $request->all();
		$jobSearch = JobPost::where('is_active', 1)->with('user')
			->when(isset($search['title']), function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search['title'] . '%');
			})
			->when(isset($search['category_id']), function ($query) use ($search) {
				$query->where('category_id', $search['category_id']);
			})
			->when(isset($search['my_range']),function ($query) use ($search){
				$query->whereBetween('fixed_rate',explode(';',$search['my_range']));
			})
			->when(isset($search['type']), function ($query) use ($search) {
				$query->where('job_type', $search['type']);
			})
			->when(isset($search['experience']), function ($query) use ($search) {
				$query->where('experience', $search['experience']);
			})
			->latest()->get()->map(function ($item) {
				$item->title_route = route('user.jobs.details', [slug($item->title), $item->id]);
				$item->posted = diffForHumans($item->created_at);
				$item->country = $item->user->profile->getCountry->name;

				if ($item->start_rate != 0 && $item->end_rate != 0) {
					$item->rate = $item->start_rate . '-' . $item->end_rate;
				} else {
					$item->rate = $item->fixed_rate;
				}

				if ($item->experience == 1) {
					$item->expr = 'Entry';
				} elseif ($item->experience == 2) {
					$item->expr = 'Intermidiate';
				} else {
					$item->expr = 'Expert';
				}
				return $item;
			});
		return response()->json($jobSearch);
	}

	public function jobList()
	{
		if (Auth::check()) {
			$joblists = JobPost::where('creator_id', auth()->user()->id)->where('status', 1)->latest()->paginate(config('basic.paginate'));
			$basicControl = basicControl();
			return view($this->theme . 'user.job.lists', compact('joblists', 'basicControl'));
		} else {
			return back()->with('error', 'Please login your account to check job details');
		}
	}

	public function jobCreate()
	{
		$pageTag = "Create Job";
		$data['categories'] = Category::with('details')->latest()->get();
		$data['skills'] = Skill::get();
		$data['scopes'] = Scope::get();
		$data['durations'] = Duration::orderBy('frequency', 'asc')->get();
		return view($this->theme . 'user.job.jobCreate', $data, compact('pageTag'));
	}

	public function jobStore(Request $request)
	{

		$rules = [
			'title' => 'required|max:100|min:6',
			'category_id' => 'required|integer|exists:categories,id',
			'job_type' => 'required',
			'skill' => 'required|string',
			'description' => 'required|string|max:500',
			'duration' => 'required|string',
		];
		$message = [
			'title.max' => 'Title field may not be greater than :max characters.',
			'title.min' => 'Title field may not be less than :min characters.',
		];

		$validator = Validator::make($rules, $message);
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		$job = new JobPost();
		$job->title = $request->title;
		$job->category_id = $request->category_id;
		$job->creator_id = auth()->user()->id;
		$job->scope = $request->scope;
		$job->duration = $request->duration;
		$job->skill = implode(',', $request->skill);
		$job->experience = $request->experience;
		$job->job_type = $request->job_type;
		if ($job->job_type == 1) {
			$job->start_rate = $request->start_rate;
			$job->end_rate = $request->end_rate;
		} else {
			$job->fixed_rate = $request->fixed_rate;
		}
		if ($request->attachment) {
			try {
				$name = 'attachment' . '_' . date('Y') . '-' . date('m') . '-' . date('d') . '_' . strRandom(3);
				$attachment = $this->fileUpload($request->attachment, config('location.job.path'), null, $name);

				if ($attachment) {
					$job->attachment = $attachment['path'] ?? null;
					$job->driver = $attachment['driver'] ?? null;
					$job->attachment_name = $name;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'Attachment could not be uploaded');
			}
		}

		$job->requirements = json_encode($request->requirementsQues);
		$job->description = $request->description;
		$job->note = $request->note;
		$job->save();

		$msg = [
			'client' => auth()->user()->name,
			'title' => $request->title,
		];

		$adminAction = [
			"link" => route('admin.jobs'),
			"icon" => "fas fa-user text-white"
		];

		$this->adminMail($type = 'JOB_POST', [
			'client' => auth()->user()->name,
			'title' => $request->title,
			'link' => route('admin.jobs'),
		]);

		$this->adminPushNotification('JOB_POST', $msg, $adminAction);
		$this->adminFirebasePushNotification('JOB_POST',$msg,$adminAction);

		return redirect()->route('user.jobs.list')->with('success', 'Job post successfully');
	}

	public function jobDetails($slug = null, $id)
	{
		if (Auth::check()) {

			$exists = JobProposal::where('job_id', $id)->where('proposer_id', auth()->user()->id)->first();
			$data['jobDetails'] = JobPost::where('id', $id)->with('user', 'hire', 'invite')
									->whereHas('user',function ($query){
										$query->where('status',1);
									})
									->firstOrFail();
			$query = JobPost::where('creator_id', $data['jobDetails']->creator_id);
			$data['totalPost'] = $query->count();
			$data['relatedJobsCount'] = $query->where('id', '!=', $id)->count();
			$data['showRelatedJobs'] = $query->limit(2)->latest()->get();

			$data['running'] = JobPost::where('creator_id', $data['jobDetails']->creator_id)->where('status', 1)->count();
			$data['completed'] = JobPost::where('creator_id', $data['jobDetails']->creator_id)
				->where('status', 2)
				->count();

			$data['creator_location'] = User::where('id', $data['jobDetails']->creator_id)->with('profile')->firstOrFail();
			$data['user_profile'] = UserProfile::where('user_id', auth()->user()->id)->with('getCountry')->firstOrFail();

			// invite count....
			$data['total_invite'] = Invitation::where('job_id', $id)->count();
			$data['unanswer_invite'] = Invitation::where('job_id', $id)->where('status', '!=', 1)->count();

//			interview count..
			$data['interview'] = Messenger::where('job_id', $id)->count();
			$url = Request()->url();
			return view($this->theme . 'user.job.jobDetails', $data, compact('url', 'exists'));
		} else {
			return redirect()->route('login')->with('error', 'Please login your account to check job details.');
		}
	}

	public function jobProposal($slug, $id)
	{
		if (Auth::check()) {
			$data['proposal'] = JobPost::where('id', $id)->with('user')->whereHas('user',function ($query){
								$query->where('status',1);
			})->firstOrFail();
			$data['service_fee'] = ServiceFee::where('status', 1)->get();
			$data['service_fee_value'] = $data['service_fee']->firstOrFail()->percentage;
			$data['durations'] = Duration::orderBy('duration', 'asc')->get();

			$query = JobPost::where('creator_id', $data['proposal']->creator_id);
			$data['totalPost'] = $query->count();

			$data['running'] = $query->where('status', 1)->count();
			$data['completed'] = $query->where('status', 2)->count();

			$data['creator_location'] = User::where('id', $data['proposal']->creator_id)->with('profile')->firstOrFail();

			return view($this->theme . 'user.job.proposal', $data);
		}
	}

	public function jobProposalStore(Request $request, $slug, $id)
	{
		if (Auth::check()) {
			$request->validate([
				'cover_letter' => 'required|string|max:500',
				'describe_experience' => 'required|max:500',
				'file' => 'required|string',
				'bid_amount' => 'required|numeric',
			]);

			$user = auth()->user();
			$daily_limit = $user->profile->daily_limit;

			if ($daily_limit > 0) {
				$proposal = new JobProposal();
				$proposal->job_id = $request->job_id;
				$proposal->proposer_id = $user->id;
				$proposal->cover_letter = $request->cover_letter;
				$proposal->describe_experience = $request->describe_experience;
				$proposal->duration_id = $request->duration;
				$proposal->bid_amount = $request->bid_amount;
				$proposal->receive_amount = $request->receive_amount;

				$is_invite = Invitation::where('job_id', $request->id)
					->where('to_freelancer', $user->id)
					->where('status', 1)->firstOrFail();

				if ($is_invite) {
					$proposal->is_invite = 1;
				}
				if ($request->file) {
					try {
						$name = 'document' . '_' . date('Y') . '-' . date('m') . '-' . date('d') . '_' . strRandom(3);
						$image = $this->fileUpload($request->file, config('location.job_proposal.path'), null, $name);
						if ($image) {
							$proposal->file = $image['path'];
							$proposal->driver = $image['driver'];
							$proposal->file_name = $name;
						}
					} catch (\Exception $e) {
						return back()->with('alert', 'Image could not be uploaded');
					}
				}
				$proposal->save();
				$count_proposal = JobPost::findOrFail($proposal->job_id);
				$count_proposal->increment('total_proposal');
				$count_proposal->save();

				$daily_limit -= 1;
				$user_profile = UserProfile::where('user_id', $user->id)->firstOrFail();
				$user_profile->daily_limit = $daily_limit;
				$user_profile->save();

				$job = JobPost::where('id', $request->job_id)->firstOrFail();
				$creator = $job->user;

				$msg = [
					'proposser' => $user->name,
					'amount' => getAmount($proposal->bid_amount),
					'title' => $job->title,
					'currency' => 'USD'
				];
				$userAction = [
					"link" => route('user.jobs.list'),
					"icon" => "fas fa-user text-white"
				];
				$adminAction = [
					"link" => route('admin.jobs'),
					"icon" => "fas fa-user text-white"
				];

				$this->sendMailSms($creator, $type = 'APPLY_JOB', [
					'proposer' => $user->name,
					'amount' => getAmount($proposal->bid_amount),
					'title' => $job->title,
					'currency' => 'USD',
					'link' => route('user.jobs.details', ['slug' => $job->title, 'id' => $job->id]),
				]);

				$this->adminMail($type = 'APPLY_JOB', [
					'proposer' => $user->name,
					'amount' => getAmount($proposal->bid_amount),
					'title' => $job->title,
					'currency' => 'USD',
					'link' => route('user.jobs.details', ['slug' => $job->title, 'id' => $job->id]),
				]);

				$this->adminPushNotification('APPLY_JOB', $msg, $adminAction);
				$this->userPushNotification($creator, 'APPLY_JOB', $msg, $userAction);
				$this->adminFirebasePushNotification('APPLY_JOB',$msg,route('admin.jobs'));
				$this->userFirebasePushNotification($creator,'APPLY_JOB',$msg,route('user.jobs.list'));
				return redirect()->route('jobs')->with('success', 'Job proposal successfully stored');
			}

		} else {
			return redirect()->back()->with('alert', 'You are not eligible for this proposal');
		}
	}

	public function proposalList($id)
	{
		if (Auth::check()) {

			$data['proposals'] = JobProposal::where('job_id', $id)
				->with('job', 'proposer', 'durations')
				->orderBy('is_invite', 'desc')
				->paginate(config('basic.paginate'));
			return view($this->theme . 'user.job.proposalList', $data);
		}
	}

	public function checkFee(Request $request)
	{
		if (Auth::check()) {
			if ($request->bid_amount != 0) {
				$bidAmount = $request->bid_amount;
			}
			$serviceFee = ServiceFee::where('status', 1)
				->where(function ($query) use ($bidAmount) {
					$query->whereNull('bid_start')
						->orWhereNull('bid_end')
						->orWhere(function ($query) use ($bidAmount) {
							$query->where('bid_start', '<=', $bidAmount)
								->where('bid_end', '>=', $bidAmount)
								->orWhere(function ($query) use ($bidAmount) {
									$query->where('bid_start', '<=', $bidAmount)
										->whereNull('bid_end');
								});
						});
				})
				->first('percentage');

			if ($serviceFee) {
				return response()->json($serviceFee);
			} else {
				return response()->json('');
			}
		}
	}

	public function proposserDetails($id)
	{
		$data['details'] = JobProposal::with('proposer')->findOrFail($id);
		$auth = auth()->user();
		$data['chat'] = Chat::with('chatable')->get()->pluck('chatable')->unique('chatable');

		return view($this->theme . 'user.job.proposserDetails', $data);
	}

	public function hire($proposerId, $jobId, $proposal_id)
	{

		$data['proposerId'] = $proposerId;
		$data['jobId'] = $jobId;
		$data['proposalId'] = $proposal_id;
		$data['proposal'] = JobProposal::findOrFail($proposal_id);
		return view($this->theme . 'user.job.hire', $data);
	}

	public function hireStore(Request $request)
	{
		if (Auth::check()) {
			$request->validate([
				'submit_date' => "required|date",
				"description" => "required|string|max:500",
				'deposit_type' => "required"
			]);

			$exists = Hire::where('proposser_id', $request->proposser_id)->where('job_id', $request->job_id)->firstOrFail();
			if ($exists) {
				return redirect()->back()->with('alert', 'Hire proposser already exists');
			}

			$hire = new Hire();
			$hire->client_id = $request->client_id;
			$hire->proposser_id = $request->proposser_id;
			$hire->job_id = $request->job_id;
			$hire->proposal_id = $request->proposal_id;
			$hire->pay_type = $request->pay_type;
			$hire->rate = $request->rate;
			$hire->deposit_type = $request->deposit_type;
			$hire->submit_date = $request->submit_date;
			$hire->description = $request->description;
			$hire->save();

			if ($request->deposit_type == 1) {
				$escrow = new Escrow();
				$escrow->hire_id = $hire->id;
				$escrow->budget = $request->rate;
				$escrow->payment_date = $request->submit_date;
				$escrow->paid = 0;
				$escrow->save();
			}

			if ($request->deposit_type == 2) {
				$request->validate([
					'deposit_amount.*' => 'required|numeric',
					'payment_date.*' => 'required'
				]);
				$installments = $request->deposit_amount;
				$milestoneDesc = $request->milestone_desc;
				$remainingAmount = $request->rate;

				foreach ($installments as $key => $installment) {
					$escrow = new Escrow();
					$escrow->hire_id = $hire->id;
					$escrow->budget = $remainingAmount;
					$escrow->escrow_amount = $installment;
					$escrow->payment_date = $request->payment_date[$key];
					$escrow->milestone_desc = $milestoneDesc[$key];
					$escrow->save();
					$remainingAmount -= $installment;
				}
			}

			$influencer = User::findOrFail($hire->proposser_id);
			$msg = [
				'client' => $hire->client->name,
				'rate' => getAmount($hire->rate),
				'job' => $hire->job->title,
				'currency' => basicControl()->base_currency,
			];
			$userAction = [
				"link" => route('user.myproposal.list'),
				"icon" => "fas fa-user text-white"
			];
			$adminAction = [
				"link" => route('admin.jobs'),
				"icon" => "fas fa-user text-white"
			];

			$this->sendMailSms($influencer, $type = 'HIRE_INFLUENCER', [
				'client' => $hire->client->name,
				'amount' => getAmount($hire->rate),
				'title' => $hire->job->title,
				'currency' => basicControl()->base_currency,
				'link' => route('user.myproposal.list'),
			]);
			$this->adminMail($type = 'HIRE_INFLUENCER', [
				'client' => $hire->client->name,
				'amount' => getAmount($hire->rate),
				'title' => $hire->job->title,
				'currency' => basicControl()->base_currency,
				'link' => route('user.myproposal.list'),
			]);

			$this->adminPushNotification('HIRE_INFLUENCER', $msg, $adminAction);
			$this->userPushNotification($influencer, 'HIRE_INFLUENCER', $msg, $userAction);
			$this->adminFirebasePushNotification('HIRE_INFLUENCER',$msg,$adminAction);
			$this->userFirebasePushNotification($influencer,'HIRE_INFLUENCER',$msg,route('user.myproposal.list'));
			return redirect()->back()->with('success', 'Hire proposser successfully');
		} else {
			return back()->with('error', 'Please login your account to check job details');
		}
	}

	public function saveList(Request $request)
	{
		if (Auth::check()) {
			$data['basicControl'] = basicControl();
			$data['catagorDetails'] = CategoryDetails::with('category')->get();
			$query = JobPost::where('status', 1)->latest()->with('user', 'jobSave');

			// Filter the JobPost records based on related JobSave records with is_saved = true
			$query->whereHas('jobSave', function ($query) {
				$query->where('user_id', auth()->user()->id);
			});

			$data['jobs'] = $query->get();
			$data['job_count'] = $data['jobs']->count();
			$data['min'] = $data['jobs']->min('start_rate');
			$data['max'] = $data['jobs']->max('end_rate');
			$data['job_types'] = Scope::firstOrFail();
			$data['dislike_reasons'] = DislikeReason::get();

			if ($request->ajax()) {
				$view = view($this->theme . 'job_post', $data)->render();
				return response()->json(['html' => $view]);
			}
			return view($this->theme . 'jobs', $data);
		}
		return redirect()->route('login')->with('error', 'Please login your account to check job details.');
	}

	public function jobSave($id)
	{
		if (Auth::check()) {
			$is_saved = JobSave::where('is_saved', 1)->where('job_id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
			if (!$is_saved) {
				$jobSave = new JobSave();
				$jobSave->job_id = $id;
				$jobSave->user_id = auth()->user()->id;
				$jobSave->is_saved = 1;
				$jobSave->save();
				return redirect()->back()->with('success', 'Job save successfully');
			} else {
				return back()->with('error', 'Job already saved');
			}
		}
	}

	// job offer

	public function jobOffer($id)
	{
		if (Auth::check()) {

			$proposer = auth()->user();
			$data['offer'] = Hire::where('id', $id)->with('job')->first();
			$data['offers'] = Hire::where('proposser_id', $proposer->id)->distinct()->latest()->with('job')->paginate(config('basic.paginate'));

			return view($this->theme . 'user.job.job_offer', $data);
		} else {
			return redirect()->back()->with('error', 'Please login your account to check job details.');
		}
	}

//	send_offer
	public function sendOffer(Request $request)
	{
		if (Auth::check()) {
			$client = auth()->user();
			$query = Hire::where('client_id', $client->id)->latest()->with('job', 'proposser');
			$data['send_offers'] = $query->paginate(3);
			$data['offer_count'] = $query->count();
			if ($request->ajax()) {
				$view = view($this->theme . 'infinite.send_offer_iteration', $data)->render();
				return response()->json(['html' => $view]);
			}

			return view($this->theme . 'user.job.send_offer', $data);
		} else {
			return redirect()->back()->with('error', 'Please login your account to check job details.');
		}
	}

	public function jobOfferAccept($job_id)
	{
		if (Auth::check()) {
			$accept_job = Hire::where('job_id', $job_id)->with('job', 'client')->firstOrFail();
			if ($accept_job->is_hired == 0) {
				$accept_job->is_hired = 1;
				$accept_job->save();
			} else {
				return back()->with('alert', 'Already hired');
			}
			return back()->with('success', 'Job offer accepted successfully');
		}
		abort(404);
	}

	public function jobOfferCancel($job_id)
	{
		$cancel_offer = Hire::where('job_id', $job_id)->firstOrFail();
		$cancel_offer->delete();
		return redirect()->route('user.job.offer')->with('success', 'Offer cancelation successfully.');
	}

	public function skillSearch(Request $request, $item)
	{
		$data['basicControl'] = basicControl();
		$data['catagorDetails'] = CategoryDetails::with('category')->get();
		$data['jobs'] = JobPost::where('status', 1)
			->where('skill', 'LIKE', '%' . $item . '%')
			->latest()
			->with('user')
			->get();

		$data['job_count'] = $data['jobs']->count();
		$data['min'] = $data['jobs']->min('start_rate');
		$data['max'] = $data['jobs']->max('end_rate');
		$data['job_types'] = Scope::first();
		$data['dislike_reasons'] = DislikeReason::get();

		if ($request->ajax()) {
			$view = view($this->theme . 'job_post', $data)->render();
			return response()->json(['html' => $view]);
		}
		return view($this->theme . 'jobs', $data);
	}

	public function bestMatches(Request $request)
	{
		if (Auth::check()) {
			$data['basicControl'] = basicControl();
			$data['catagorDetails'] = CategoryDetails::with('category')->get();
			$user = auth()->user();
			$query = JobPost::where('status', 1)->where('creator_id', $user->id)->latest()->with('user')->whereHas('user',function($q){
				$q->where('status',1);
			});

			$userSkills = explode(',', $user->profile->skills); // Convert string to array
			$data['jobs'] = $query->where(function ($query) use ($userSkills) {
				if (is_array($userSkills)) {
					foreach ($userSkills as $item) {
						$query->orWhere('skill', 'LIKE', '%' . $item . '%');
					}
				}
			})->get();

			$data['job_count'] = $data['jobs']->count();
			$data['min'] = $data['jobs']->min('start_rate');
			$data['max'] = $data['jobs']->max('end_rate');
			$data['job_types'] = Scope::first();

			$data['dislike_reasons'] = DislikeReason::get();

			if ($request->ajax()) {
				$view = view($this->theme . 'job_post', $data)->render();
				return response()->json(['html' => $view]);
			}
			return view($this->theme . 'jobs', $data);
		}
		return redirect()->route('login')->with('error', 'Please login your account to check job details.');
	}

//	myproposal list
	public function myproposals()
	{
		$activeTab = 'active';
		$proposer = auth()->user();

		$proposal = JobProposal::where('proposer_id', $proposer->id)->with('job');
		$data['proposals'] = $proposal->get();
		$proposal_count = $proposal->count();

		$query = Hire::query();
		$data['offers'] = $query->where('proposser_id', $proposer->id)->distinct()->latest()->with('job')->get();

		$data['active_proposals'] = $query->where('proposser_id', $proposer->id)->whereHas('escrow', function ($query) {
			$query->where('is_submitted', 0);
		})->count();

		$data['submitted'] = Hire::where('proposser_id', $proposer->id)->whereHas('escrow', function ($query) {
			$query->where('is_submitted', 1);
		})->get();
		$data['interviews'] = Messenger::where('receiver_id', $proposer->id)->where('job_id', '!=', 0)->with('job')->get();

		return view($this->theme . 'user.job.myproposals', $data, compact('activeTab', 'proposal_count'));
	}

	public function offers()
	{
		$proposer = auth()->user();
		$query = Hire::where('proposser_id', $proposer->id)->distinct()->latest()->with('job')->get();
		return DataTables::of($query)
			->addColumn('title', function ($item) {
				return $item->job->title;
			})
			->addColumn('rate', function ($item) {
				return basicControl()->currency_symbol . $item->rate;
			})
			->addColumn('submit_date', function ($item) {
				return $item->submit_date;
			})
			->addColumn('accept', function ($item) {
				$url = route('user.job.accept', $item->job->id);
				if ($item->is_hire == 0) {
					return '<a href="' . $url . '" class="btn-action btn-primary">' . __('Accept') . '</a>';
				} else {
					return 'Accepted';
				}
			})
			->rawColumns(['accept'])
			->make(true);
	}

	public function allProposal()
	{
		$proposer = auth()->user();
		$query = JobProposal::where('proposer_id', $proposer->id)->with('job')->get();
		return DataTables::of($query)
			->addColumn('title', function ($item) {
				return $item->job->title;
			})
			->addColumn('bid_amount', function ($item) {
				return basicControl()->currency_symbol . $item->bid_amount;
			})
			->addColumn('receive_amount', function ($item) {
				return basicControl()->currency_symbol . $item->receive_amount;
			})
			->addColumn('details_link', function ($item) {
				$url = route('user.jobs.details', ['slug' => $item->job->title, 'id' => $item->job->id]);
				return '<a href="' . $url . '" class="btn-action">' . __('Details') . '</a>';
			})->rawColumns(['details_link'])
			->make(true);
	}

	public function interview()
	{
		$proposer = auth()->user();
		$query = Messenger::where('receiver_id', $proposer->id)->where('job_id', '!=', 0)->with('job')->get();

		return DataTables::of($query)
			->addColumn('title', function ($item) {
				return $item->job->title;
			})
			->addColumn('experience', function ($item) {
				return $item->job->experience;
			})
			->addColumn('skills', function ($item) {
				return $item->job->skill;
			})
			->addColumn('details_link', function ($item) {
				$url = route('user.jobs.details', ['slug' => $item->job->title, 'id' => $item->job->id]);
				return '<a href="' . $url . '" class="btn-action btn-primary">' . __('Details') . '</a>';
			})->rawColumns(['details_link'])
			->make(true);
	}

	public function submitted()
	{
		$proposer = auth()->user();
		$query = Hire::query();
		$data = $query->where('proposser_id', $proposer->id)->whereHas('escrow', function ($query) {
			$query->where('is_submitted', 1);
		})->get();


		return DataTables::of($data)
			->addColumn('title', function ($item) {
				return $item->job->title;
			})
			->addColumn('submite_date', function ($item) {
				return $item->submit_date;
			})
			->addColumn('details', function ($item) {
				$url = route('user.jobs.details', ['slug' => $item->job->title, 'id' => $item->job->id]);
				return '<a href="' . $url . '" class="btn-action btn-outline-primary">' . __('Details') . '</a>';
			})->rawColumns(['details'])
			->make(true);
	}

	public function archived()
	{
		$proposer = auth()->user();
		$query = JobProposal::where('proposer_id', $proposer->id)->with('job');

		return DataTables::of($query)
			->addColumn('title', function ($item) {
				return Str::limit($item->job->title, 20);
			})
			->addColumn('bid_amount', function ($item) {
				return basicControl()->currency_symbol . $item->bid_amount;
			})
			->addColumn('receive_amount', function ($item) {
				return basicControl()->currency_symbol . $item->receive_amount;
			})
			->addColumn('status', function ($item) {
				if ($item->job->status === 1) {
					return __('Running');
				} elseif ($item->job->status === 2) {
					return __('Completed');
				} else {
					return __('Unknown');
				}
			})
			->addColumn('details_link', function ($item) {
				$url = route('user.jobs.details', ['slug' => $item->job->title, 'id' => $item->job->id]);
				return '<a href="' . $url . '" class="btn-action">' . __('Details') . '</a>';
			})->rawColumns(['details_link'])
			->make(true);
	}

	public function completed(Request $request, $j_id)
	{
		$job = JobPost::find($j_id);
		$job->status = 2;
		$job->is_active = 0;
		$job->save();
		return back()->with('success', 'Successfully completed.');
	}
}
