<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\JobPost;
use App\Models\JobProposal;
use App\Models\Transfer;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\Escrow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Sodium\increment;

class EscrowController extends Controller
{
	use Upload, Notify;

	public $theme, $user;

	public function __construct()
	{
		$this->theme = template();
	}

	public function milestoneList($title,$hireId)
	{
		$data['escrows'] = Escrow::where('hire_id', $hireId)->with('hire.job')->get();
		$hasEscrowAmount = $data['escrows']->contains('escrow_amount', '>', 0);
		$cur_date = now()->format('d M Y');
		return view($this->theme . 'user.milestone.list', $data,compact('cur_date','hasEscrowAmount'));
	}

	public function fileSubmit(Request $request, $id)
	{
		$request->validate([
			'file' => 'required'
		]);
		$file_submit = Escrow::find($id);
		if ($request->file) {
			try {
				$name = 'document'.'_' . date('Y') . '-' . date('m') . '-' . date('d').'_'. strRandom(3);
				$file = $this->fileUpload($request->file, config('location.order.path'), null, $name);
				if ($file) {
					$file_submit->project_file = $file['path'] ?? null;
					$file_submit->driver = $file['driver'] ?? null;
					$file_submit->file_name = $name;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'File could not be uploaded');
			}
		}
		$file_submit->is_submitted = 1;
		$file_submit->save();
		return redirect()->back()->with('success', 'Succesfully delivered the order');
	}

	public function exceptMilestone($hireId)
	{
		$data['escrows'] = Escrow::where('hire_id',$hireId)->with('hire.job')->paginate(config('basic.paginate'));
		$cur_date = now()->format('d M Y');
		return view($this->theme.'user.order.completed',$data,compact('cur_date'));
	}

	public function completed ($id=null)
	{
		$complete_job = JobPost::with('proposal')->find($id);
		$complete = $complete_job->proposal->pluck('proposer_id')->firstOrFail();
		$user = User::find($complete);
		if($complete_job->status == 1)
		{
			$complete_job->status = 2;
			$user->increment('completed_order');
			$user->save();
			$complete_job->save();
			return back()->with('success','Order completed successfully.');
		}
		else{
			return back()->with('alert','Already completed');
		}
	}

	public function jobPayment(Request $request)
	{
		$amount = $request->amount;
		$proposser_id = $request->proposser_id;
		$escrow_id = $request->id;
		$client_id = $request->client_id;
		$proposal_id = $request->proposal_id;
		$client = User::findOrFail($client_id);

		if($request->payment_method == 1)
		{
			if($client->balance < $amount)
			{
				return back()->with('alert','Client has insufficient balance');
			}
			$utr= $this->checkWalletPayment($amount,$client_id,$proposser_id,$escrow_id,$proposal_id);
			session()->put('escrow_id',$escrow_id);
			return redirect()->route('transfer.confirm.job.payment',$utr)->with('success','Transfer initiated successfully');
		}

		elseif ($request->payment_method == 2)
		{
			return redirect()->route('fund.initialize.job',$escrow_id);
		}
	}

	public function checkWalletPayment($amount,$client_id,$proposser_id,$escrow_id,$proposal_id)
	{
		$proposser = User::findOrFail($proposser_id);
		$proposal = JobProposal::findOrFail($proposal_id);
		$receive_amount = $proposal->receive_amount;
		$transfer = new Transfer();
		$transfer->sender_id = $client_id;
		$transfer->receiver_id = $proposser_id;
		$transfer->amount = $amount;
		$transfer->charge = $amount - $receive_amount;
		$transfer->charge_percentage = (($amount - $receive_amount)/$amount)*100;
		$transfer->transfer_amount = $amount;
		$transfer->received_amount = $receive_amount;
		$transfer->note = 'Job order payment from wallet';
		$transfer->email = $proposser->email;
		$transfer->status = 0;// 1 = success, 0 = pending
		$transfer->utr = (string)Str::uuid();
		$transfer->save();
		return $transfer->utr;

	}

}
