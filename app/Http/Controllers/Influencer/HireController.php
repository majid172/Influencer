<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\Upload;
use App\Models\Hire;
use Illuminate\Support\Facades\Auth;

class HireController extends Controller
{
	use Upload,Notify;
	public $theme, $user;

	public function __construct()
	{
		$this->theme = template();
	}
    public function hire()
	{
		if (Auth::check())
		{
			$client = auth()->user();
			$data['hires'] = Hire::where('client_id',$client->id)->with('job','proposser','escrow')->get();
			return view($this->theme.'user.order.freelancer_hire',$data);
		}
		return back()->with('error','Please login your account to check job details');
	}

	public function expandDate(Request $request)
	{
		$request->validate([
			'submit_date' => 'required',
		]);
		$expand_date = Hire::find($request->id);
		$expand_date->submit_date = $request->submit_date;
		$expand_date->save();
		return back()->with('success','Date expanded successfully');
	}

	public function receiveProject()
	{
		return view($this->theme.'user.hire.order_receive');
	}


}
