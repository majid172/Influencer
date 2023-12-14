<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Gateway;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Str;

use Illuminate\Http\Request;

class ListingCheckoutController extends Controller
{
	public function selectGateway(Request $request)
	{

		$paymentId = $request->paymentId;
		$data['paymentGatewayInfo'] = Gateway::findOrFail($paymentId);
		return response()->json(['data' => $data]);
	}


	public function payment(Request $request)
	{
		$user = Auth::user();
		$gate = Gateway::whereStatus(1)->findOrFail($request->gateway);
		if ($request->gateway) {
			$reqAmount = $request->amount;
			$charge = getAmount($gate->fixed_charge + ($reqAmount * $gate->percentage_charge / 100));
			$payable = getAmount($reqAmount + $charge);
			$final_amo = getAmount($payable * $gate->convention_rate);
			$fund = PaymentController::newFund($request, $user, $gate, $charge, $final_amo, $reqAmount);
			session()->put('track', $fund['transaction']);
			return redirect()->route('addFund.confirm');

		}


		$charge = $request->charge_fixed + $request->charge_percentage;

		$transfer = new Transfer();
		$transfer->sender_id = $request->sender_id;
		$transfer->receiver_id = $request->receiver_id;
		$transfer->amount = $request->amount;
		$transfer->charge_percentage = $request->percentageCharge;
		$transfer->charge_fixed = $request->fixedCharge;
		$transfer->charge = $charge;
		$transfer->transfer_amount = $request->amount + $charge;
		$transfer->received_amount = $request->amount;
		$transfer->status = 0;
		$transfer->utr = (string)Str::uuid();
		$transfer->save();
		return back()->with('success','Listing payment successfully.');
	}

}
