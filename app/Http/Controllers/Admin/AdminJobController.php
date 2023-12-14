<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Escrow;
use App\Models\Hire;
use App\Models\JobPost;
use App\Models\Duration;
use App\Models\JobProposal;
use App\Models\ServiceFee;
use App\Models\DislikeReason;
use App\Models\User;
use App\Traits\Notify;
use Illuminate\Http\Request;


class AdminJobController extends Controller
{
	use Notify;
    public function jobs()
	{
		$jobs = JobPost::with('user','category')->paginate(config('basic.paginate'));
		$categories = Category::get();
		return view('admin.job.index',compact('jobs','categories'));
	}
	public function jobSearch(Request $request)
	{
		$search = $request->all();
		$categories = Category::get();
		$jobs = JobPost::with('user')
			->when(isset($search['title']), function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search['title'] . '%');
			})
			->when(isset($search['category_id']),function ($query) use ($search){
				$query->where('category_id',$search['category_id']);
			})
			->when(isset($search['job_type']),function ($query) use ($search){
				$query->where('job_type',$search['job_type']);
			})
			->when(isset($search['status']),function ($query) use($search){
				$query->where('status',$search['status']);
			})
			->latest()->paginate(config('basic.paginate'));

		return view('admin.job.index',compact('jobs','categories'));
	}

	public function approve($id)
	{
		$approveJob = JobPost::findOrFail($id);
		if($approveJob->status == 1)
		{
			return redirect()->back()->with('error','Already approve this job');
		}
		$approveJob->status = 1;
		$approveJob->save();
		$msg = [
			'title' => $approveJob->title,
		];
		$client = User::findOrFail($approveJob->creator_id);

		$userAction = [
			"link" => route('user.jobs.list'),
			"icon" => "fas fa-user text-white"
		];
		$this->userPushNotification($client,'JOB_APPROVE', $msg, $userAction);
		return redirect()->back()->with('success','Successfully approve this job');

	}

	public function jobDetails($id)
	{
		$details = JobProposal::where('job_id',$id)->with('job','proposer')->paginate(config('basic.paginate'));
		return view('admin.job.details',compact('details'));
	}

	public function serviceFee()
	{
		$service_fee = ServiceFee::paginate(config('basic.paginate'));
		return view('admin.job.serviceFee',compact('service_fee'));
	}

	public function serviceFeeStore(Request $request)
	{

		$levelGenerate = $request->input('levelGenerate');
		$types = $request->input('type');
		$bidStarts = $request->input('bid_start');
		$bidEnds = $request->input('bid_end');
		$percentages = $request->input('percentage');

		for ($i = 0; $i < $levelGenerate; $i++) {
			$serviceFee 			= new ServiceFee();
			$serviceFee->type 		= $types[$i];
			$serviceFee->bid_start 	= $bidStarts[$i];
			$serviceFee->bid_end 	= $bidEnds[$i];
			$serviceFee->percentage = $percentages[$i];
			$serviceFee->save();
		}
		return redirect()->back()->with('success','Service fee store successfully');

	}

	public function serviceFeeUpdate(Request $request)
	{
		$request->validate([
			'bid_start' => 'required|numeric',
			'percentage' => 'required',
		]);
		$fee = ServiceFee::find($request->id);
		$fee->bid_start 	= $request->bid_start;
		$fee->bid_end 		= $request->bid_end;
		$fee->percentage 	= $request->percentage;
		$fee->save();
		return back()->with('success','Service fee update successfully');

	}

	public function changeStatus($type)
	{
		$deactivateStatus = ServiceFee::where('type', '!=', $type)->where('status', 1)->update(['status' => 0]);
		$activateStatus = ServiceFee::where('type', $type)->where('status', 0)->get();
		if ($activateStatus) {
			foreach($activateStatus as $item)
				{
					$item->status = 1;
					$item->save();
				}
			}

		return redirect()->back()->with('success','Status change successfully');
	}

	public function hireList()
	{
		$hires = Hire::paginate(config('basic.paginate'));
		return view('admin.job.hire',compact('hires'));
	}

	public function hireSearch(Request $request)
	{
		$search = $request->all();
	
		$hires = Hire::with('proposal','job','client','proposser')
				->when(isset($search['client']),function ($query) use ($search){
					return $query->whereHas('client',function ($qry) use ($search){
						$qry->where('name','LIKE','%'.$search['client'].'%');
					});
				})
				->when(isset($search['proposser']),function ($query) use ($search){
					return $query->whereHas('proposser',function ($qry) use($search){
						$qry->where('name','LIKE','%'.$search['proposser'].'%');
					});
				})
				->when(isset($search['payment_type']),function ($query) use ($search){
					$query->where('deposit_type',$search['project_type']);
				})
			->paginate(config('basic.paginate'));
			return view('admin.job.hire',compact('hires'));

	}

	public function hireListDelete($hire_id)
	{
		$hire = Hire::findOrFail($hire_id);
		$hire->delete();
		return back()->with('success','Hire data remove from list.');
	}

	public function escrow($hire_id)
	{
		$escrows = Escrow::where('hire_id',$hire_id)->paginate(config('basic.paginate'));
		return view ('admin.job.escrow',compact('escrows'));
	}

	public function escrowDelete($escrow_id)
	{
		$escrow = Escrow::findOrFail($escrow_id);
		$escrow->delete();
		return back()->with('success','Escrow data remove from list.');
	}

	public function dislikeReason()
	{
		$data['reasons'] = DislikeReason::get();
		return view('admin.dislike.dislike_reason',$data);
	}

	public function reasonStore(Request $request)
	{
		$request->validate([
			'reason' => 'required|string',
		]);

		$reason = new DislikeReason();
		$reason->reasons = $request->reason;
		$reason->save();
		return back()->with('success','Reason stored successfully');
	}
	public function reasonEdit($id)
	{
		$reason = DislikeReason::find($id);

		return view('admin.dislike.edit',compact('reason'));
	}

	public function reasonUpdate(Request $request,$id)
	{
		$request->validate([
			'reason' => 'required|string',
		]);
		$reason = DislikeReason::find($id);
		$reason->reasons = $request->reason;
		$reason->status = $request->status;
		$reason->save();
		return back()->with('success','Reason updated successfully');
	}

	public function reasonRemove($id)
	{
		$remove = DislikeReason::find($id);
		$remove->delete();
		return back()->with('success','Reason remove successfully');
	}
}
