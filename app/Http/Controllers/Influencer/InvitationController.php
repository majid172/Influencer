<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobProposal;
use App\Models\Invitation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class InvitationController extends Controller
{

	use Notify, Upload;

	public $theme, $user;

	public function __construct()
    {
        $this->theme = template();
    }


    public function sendInvite($job_id)
	{
		$auth = auth()->user();
		$data['freelancers'] = User::where('id','!=',$auth->id)->with('invitation')->get();
		$data['accept'] = User::where('id', '!=', $auth->id)
						  ->with('invitation')
						  ->whereHas('invitation', function ($query) {
							$query->where('status', 1);
						  })
						  ->get();


		$data['job'] = JobPost::find($job_id);
		$data['job_skills'] = explode(',', $data['job']->skill);

		$data['job_proposals'] = JobProposal::where('proposer_id', '!=', $auth->id)
									->with('job')
									->withCount(['job as total_completed_jobs' => function ($query) {
										$query->where('status', 2);
									}])
									->groupBy('proposer_id')
									->get();


		return view($this->theme.'user.job.send_invite',$data);
	}

	public function inviteStore(Request $request)
	{
		$invite = new Invitation();
		$invite->from_client 	= auth()->user()->id;
		$invite->to_freelancer 	= $request->to_id;
		$invite->job_id 		= $request->job_id;
		$invite->details 		= $request->details;
		$invite->save();

		$sender = auth()->user();
		$receiver = User::findOrFail($request->to_id);
		$job = JobPost::where('id',$request->job_id)->firstOrFail();
		$currentDate = Carbon::now();

        $msg = [
            'client'  	=> $sender->name,
            'job'   => $job->title,
        ];

        $userAction = [
            "link" => route('jobs'),
            "icon" => "fa fa-money-bill-alt"
        ];


        $this->userPushNotification($receiver, 'JOB_INVITATION', $msg, $userAction);

        $this->sendMailSms($receiver, 'SEND_MAIL_JOB_INVITATION', [
            'sender'      => auth()->user()->name,
            'receiver'    => $receiver->name,
            'message'     => $request->message,
            'date'        => $currentDate,
        ]);

		return back()->with('success', 'Invitation successfully');
	}

	public function receiveInvite ()
	{
		if (Auth::check()){
			$influencer = auth()->user();
			$data['invitations'] = Invitation::where('to_freelancer',$influencer->id)->latest()->with('sender','receiver','job')->get();

			return view($this->theme.'user.job.receiveInvite',$data);
		}
		return back()->with('error','Please login your account to check job details');
	}

	public function approve(Request $request)
	{
		$invite = Invitation::with('job')->findOrFail($request->id);
		$invite->status = 1;
		$invite->save();

		$data['jobDetails'] 		= JobPost::where('id',$invite->job_id)->with('user','hire','invite')->firstOrFail();

		$query 						= JobPost::where('creator_id',$data['jobDetails']->creator_id);
		$data['totalPost']			= $query->count();
		$data['relatedJobsCount'] 	= $query->where('id','!=',$invite->job_id)->count();
		$data['showRelatedJobs'] 	= $query->limit(2)->latest()->get();

		$data['running']			= JobPost::where('creator_id',$data['jobDetails']->creator_id)->where('status',1)->count();
		$data['completed'] 			= JobPost::where('creator_id', $data['jobDetails']->creator_id)
										->where('status', 2)->count();

		$data['creator_location'] 	= User::where('id',$data['jobDetails']->creator_id)->with('profile')->firstOrFail();
		$data['user_profile']		= UserProfile::where('user_id',auth()->user()->id)->with('getCountry')->firstOrFail();

		// invite count....
		$data['total_invite'] = Invitation::where('job_id',$invite->job_id)->count();
		$data['unanswer_invite'] = Invitation::where('job_id',$invite->job_id)->where('status','!=',1)->count();

		$url = Request()->url();

			return view($this->theme.'user.job.acceptJob',$data,compact('url'));
	}

	public function cancel(Request $request)
	{
		$invite = Invitation::findOrFail($request->id);
		$invite->status = 2;
		$invite->save();
		return back()->with('success','Invitation canceled successfully.');
	}
}
