<?php

namespace App\Http\Controllers\Influencer;

use App\Exports\ExportTransfer;
use App\Http\Controllers\Controller;
use App\Models\ChargeLimit;
use App\Models\Currency;
use App\Models\Escrow;
use App\Models\Gateway;
use App\Models\ServiceFee;
use App\Models\Template;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\TwoFactorSetting;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Notify;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class TransferController extends Controller
{
	use Notify;
	public $theme, $user;

	public function __construct()
	{
		$this->theme = template();
	}

	public function index()
	{
		$userId = Auth::id();
		$currencies = Currency::select('id', 'code', 'name')->orderBy('code', 'ASC')->get();

		$transfers = Transfer::with(['sender', 'receiver', 'currency','depositable'])
			->where(function ($query) use ($userId) {
				$query->where('sender_id', '=', $userId);
				$query->orWhere('receiver_id', '=', $userId);
			})
			->latest()->paginate(config('basic.paginate'));


		return view($this->theme.'user.transfer.index', compact('transfers', 'currencies'));
	}


	public function listSearch(Request $request)
	{
		$user_id = auth()->user()->id;

		if (($request->has('startDate') && $request->has('endDate')) || ($request->startDate)) {
			$startDate = $request->input('startDate');
			$endDate = $request->input('endDate');

			$dateSearch = Transfer::with(['sender', 'receiver', 'currency','depositable'])
				->where(function ($query) use ($user_id) {
					$query->where('sender_id', '=', $user_id);
					$query->orWhere('receiver_id', '=', $user_id);
				})
				->whereBetween('created_at', [$startDate, $endDate])->orWhereDate('created_at',$startDate)->latest()->get()->map(function ($item){
					$item->gateway = $item->depositable->gateway->name;
					$item->transfer_amount = basicControl()->currency_symbol.getAmount($item->amount);
					if($item->sender_id ==auth()->user()->id)
					{
						$item->type = '<span class="badge badge-success">Sent</span>';
					}
					elseif($item->receiver_id == auth()->user()->id)
					{
						$item->type = '<span class="badge badge-warning">Received</span>';
					}
					$item->statusBadge = ($item->status == 1)
						? '<span class="badge badge-success">Success</span>'
						: '<span class="badge badge-warning">Pending</span>';
					return $item;
				});

			return response()->json($dateSearch);

		}

		if(($request->status == 1) || ($request->status == 0))
		{
			$status = $this->statusSearch($request->status,$user_id);
			return response()->json($status);
		}
	}

	public function statusSearch($status,$user_id)
	{
		$statusSearch = Transfer::where('status', $status)
			->where(function ($query) use ($user_id) {
				$query->where('receiver_id', $user_id)
					->orWhere('sender_id', $user_id);
			})
			->latest()->get()
			->map(function ($item) {
				$item->gateway = $item->depositable->gateway->name;
				$item->transfer_amount = basicControl()->currency_symbol.getAmount($item->amount);
				if($item->sender_id ==auth()->user()->id)
				{
					$item->type = '<span class="badge badge-success">Sent</span>';
				}
				elseif($item->receiver_id == auth()->user()->id)
				{
					$item->type = '<span class="badge badge-warning">Received</span>';
				}
				$item->statusBadge = ($item->status == 1)
					? '<span class="badge badge-success">Success</span>'
					: '<span class="badge badge-warning">Pending</span>';
				return $item;
			});
		return $statusSearch;
	}

	public function exportTransfer(Request $request)
	{
		$data = $request->data;
		$fileName = $request->file_name ?? 'report';
		if (!$data) return;
		$headers = array_keys($request->data[0]);
		$footer = $request->footer_data;
		$export = new ExportTransfer($data, $headers, $footer);
		return Excel::download($export, $fileName.'.csv');
	}


	public function search(Request $request)
	{
		$filterData = $this->_filter($request);
		$search = $filterData['search'];
		$currencies = $filterData['currencies'];
		$userId = $filterData['userId'];
		$transfers = $filterData['transfers']
			->where(function ($query) use ($userId) {
				$query->where('sender_id', '=', $userId)->orWhere('receiver_id', '=', $userId);
			})
			->latest()
			->paginate();
		$transfers->appends($filterData['search']);
		return view('user.transfer.index', compact('search', 'transfers', 'currencies'));
	}

	public function _filter($request)
	{
		$userId = Auth::id();
		$currencies = Currency::select('id', 'code', 'name')->orderBy('code', 'ASC')->get();
		$search = $request->all();
		$sent = isset($search['type']) ? preg_match("/sent/", $search['type']) : 0;
		$received = isset($search['type']) ? preg_match("/received/", $search['type']) : 0;
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;

		$transfers = Transfer::with('sender', 'receiver', 'currency')
			->when(isset($search['email']), function ($query) use ($search) {
				return $query->where('email', 'LIKE', "%{$search['email']}%");
			})
			->when(isset($search['utr']), function ($query) use ($search) {
				return $query->where('utr', 'LIKE', "%{$search['utr']}%");
			})
			->when(isset($search['min']), function ($query) use ($search) {
				return $query->where('amount', '>=', $search['min']);
			})
			->when(isset($search['max']), function ($query) use ($search) {
				return $query->where('amount', '<=', $search['max']);
			})
			->when(isset($search['currency_id']), function ($query) use ($search) {
				return $query->where('currency_id', $search['currency_id']);
			})
			->when(isset($search['sender']), function ($query) use ($search) {
				return $query->whereHas('sender', function ($qry) use ($search) {
					$qry->where('name', 'LIKE', "%{$search['sender']}%");
				});
			})
			->when(isset($search['receiver']), function ($query) use ($search) {
				return $query->whereHas('receiver', function ($qry) use ($search) {
					$qry->where('name', 'LIKE', "%{$search['receiver']}%");
				});
			})
			->when($sent == 1, function ($query) use ($search) {
				return $query->where("sender_id", Auth::id());
			})
			->when($received == 1, function ($query) use ($search) {
				return $query->where("receiver_id", Auth::id());
			})
			->when($created_date == 1, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			})
			->when(isset($search['status']), function ($query) use ($search) {
				return $query->where('status', $search['status']);
			});

		$data = [
			'userId' => $userId,
			'currencies' => $currencies,
			'search' => $search,
			'transfers' => $transfers,
		];
		return $data;
	}

// wallet payment for listing........
	public function initializeListing(Request $request)
	{
		if ($request->isMethod('get')) {

			$currencies = Currency::select('id', 'code', 'name', 'currency_type')->where('is_active', 1)->get();
			$template = Template::where('section_name', 'send-money')->first();

			return view($this->theme.'user.transfer.listing_send', compact('currencies', 'template'));
		}
		elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validationRules = [
				'recipient' => 'required|min:4',
				'amount' => 'required|numeric|min:1|not_in:0',
				'currency' => 'required|integer|min:1|not_in:0',
				'charge_from' => 'nullable|integer|not_in:0',
			];

			$validate = Validator::make($purifiedData, $validationRules);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$amount = $purifiedData->amount;
			$currency_id = $purifiedData->currency;
			$recipient = $purifiedData->recipient;
			$charge_from = isset($purifiedData->charge_from);

			$checkAmountValidate = $this->checkAmountValidate($amount, $currency_id, config('transactionType.transfer'), $charge_from);//1 = transfer

			if (!$checkAmountValidate['status']) {
				return back()->withInput()->with('alert', $checkAmountValidate['message']);
			}

			$checkRecipientValidate = $this->checkRecipientValidate($recipient);
			if (!$checkRecipientValidate['status']) {
				return back()->withInput()->with('alert', $checkRecipientValidate['message']);
			}
			$receiver = $checkRecipientValidate['receiver'];
			$transfer = new Transfer();
			$transfer->sender_id = Auth::id();
			$transfer->receiver_id = $receiver->id;
			$transfer->currency_id = $checkAmountValidate['currency_id'];
			$transfer->percentage = $checkAmountValidate['percentage'];
			$transfer->charge_percentage = $checkAmountValidate['percentage_charge']; // amount after calculation percent of charge
			$transfer->charge_fixed = $checkAmountValidate['fixed_charge'];
			$transfer->charge = $checkAmountValidate['charge'];
			$transfer->amount = $checkAmountValidate['amount'];
			$transfer->transfer_amount = $checkAmountValidate['transfer_amount'];
			$transfer->received_amount = $checkAmountValidate['received_amount'];
			$transfer->charge_from = $checkAmountValidate['charge_from']; //0 = Sender, 1 = Receiver
			$transfer->note = $purifiedData->note;
			$transfer->email = $receiver->email;
			$transfer->status = 0;// 1 = success, 0 = pending
			$transfer->utr = (string)Str::uuid();
			$transfer->save();

			return redirect(route('transfer.listing_confirm', $transfer->utr))->with('success', 'Transfer initiated successfully');
		}
	}

	public function confirmListingTransfer(Request $request, $utr)
	{

		$user = Auth::user();
		$transfer = Transfer::with('sender', 'receiver', 'currency')->where('utr', $utr)->first();

		if (!$transfer || $transfer->status) { //Check is transaction found and unpaid
			return redirect(route('transfer.initialize.listing'))->with('success', 'Transaction already complete');
		}

		$twoFactorSetting = TwoFactorSetting::firstOrCreate(['user_id' => $user->id]);
		$enable_for = is_null($twoFactorSetting->enable_for) ? [] : json_decode($twoFactorSetting->enable_for, true);

		if ($request->isMethod('get')) {

			return view($this->theme.'user.transfer.listing_confirm', compact(['utr', 'transfer', 'enable_for']));
		}
		elseif ($request->isMethod('post')) {

			if (in_array('transfer', $enable_for)) {
				$purifiedData = Purify::clean($request->all());
			}

			$checkAmountValidate = $this->checkAmountValidate($transfer->amount, $transfer->currency_id, config('transactionType.transfer'), $transfer->charge_from);//1 = transfer

			if (!$checkAmountValidate['status']) {

				return back()->withInput()->with('alert', $checkAmountValidate['message']);
			}

			$checkRecipientValidate = $this->checkRecipientValidate($transfer->email);
			if (!$checkRecipientValidate['status']) {
				return back()->withInput()->with('alert', $checkRecipientValidate['message']);
			}

			/*
			 * Deduct money from Sender Wallet
			 * */

			$sender_wallet = updateWallet($transfer->sender_id, $transfer->currency_id, $transfer->transfer_amount, 0);
			/*
			 * Add money to receiver wallet
			 * */
			$receiver_wallet = updateWallet($transfer->receiver_id, $transfer->currency_id, $transfer->received_amount, 1);

			$transaction = new Transaction();
			$transaction->amount = $transfer->amount;
			$transaction->charge = $transfer->charge;
			$transaction->currency_id = $transfer->currency_id;
			$transfer->transactional()->save($transaction);
			$transfer->status = 1;
			$transfer->save();

//			Transfer To..
			$receivedUserTO = $transfer->receiver;
			$msg = [
				'sender' => $user->name,
				'currency' => 'USD',
				'amount' => getAmount($transaction->amount),
				'transaction' => $transfer->utr,
			];
			$userAction = [
				"link" => route('user.transaction'),
				"icon" => "fas fa-user text-white"
			];
			$this->userPushNotification($receivedUserTO, 'TRANSFER_TO', $msg, $userAction);
			$this->userFirebasePushNotification($receivedUserTO,'TRANSFER_TO',$msg,route('user.transaction'));

			return redirect(route('user.transaction'))->with("success", "Your transfer has been submitted your remaining amount of money $sender_wallet");
		}
	}

//	wallet payment for job
	public function initializeJob(Request $request)
	{

		if ($request->isMethod('get')) {

			$currencies = Currency::select('id', 'code', 'name', 'currency_type')->where('is_active', 1)->get();
			$template = Template::where('section_name', 'send-money')->first();

			return view($this->theme.'user.transfer.listing_send', compact('currencies', 'template'));
		}
		elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validationRules = [
				'recipient' => 'required|min:4',
				'amount' => 'required|numeric|min:1|not_in:0',
				'currency' => 'required|integer|min:1|not_in:0',
				'charge_from' => 'nullable|integer|not_in:0',
			];

			$validate = Validator::make($purifiedData, $validationRules);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$amount = $purifiedData->amount;
			$currency_id = $purifiedData->currency;
			$recipient = $purifiedData->recipient;
			$charge_from = isset($purifiedData->charge_from);

			$checkAmountValidate = $this->checkAmountValidate($amount, $currency_id, config('transactionType.transfer'), $charge_from);//1 = transfer

			if (!$checkAmountValidate['status']) {
				return back()->withInput()->with('alert', $checkAmountValidate['message']);
			}

			$checkRecipientValidate = $this->checkRecipientValidate($recipient);
			if (!$checkRecipientValidate['status']) {
				return back()->withInput()->with('alert', $checkRecipientValidate['message']);
			}
			$receiver = $checkRecipientValidate['receiver'];
			$transfer = new Transfer();
			$transfer->sender_id = Auth::id();
			$transfer->receiver_id = $receiver->id;
			$transfer->currency_id = $checkAmountValidate['currency_id'];
			$transfer->percentage = $checkAmountValidate['percentage'];
			$transfer->charge_percentage = $checkAmountValidate['percentage_charge']; // amount after calculation percent of charge
			$transfer->charge_fixed = $checkAmountValidate['fixed_charge'];
			$transfer->charge = $checkAmountValidate['charge'];
			$transfer->amount = $checkAmountValidate['amount'];
			$transfer->transfer_amount = $checkAmountValidate['transfer_amount'];
			$transfer->received_amount = $checkAmountValidate['received_amount'];
			$transfer->charge_from = $checkAmountValidate['charge_from']; //0 = Sender, 1 = Receiver
			$transfer->note = $purifiedData->note;
			$transfer->email = $receiver->email;
			$transfer->status = 0;// 1 = success, 0 = pending
			$transfer->utr = (string)Str::uuid();
			$transfer->save();

			return redirect(route('transfer.listing_confirm', $transfer->utr))->with('success', 'Transfer initiated successfully');
		}
	}
	public function confirmJobTransfer(Request $request, $utr)
	{
		$user = Auth::user();
		$transfer = Transfer::with('sender', 'receiver', 'currency')->where('utr', $utr)->first();

		$twoFactorSetting = TwoFactorSetting::firstOrCreate(['user_id' => $user->id]);
		$enable_for = is_null($twoFactorSetting->enable_for) ? [] : json_decode($twoFactorSetting->enable_for, true);

		if ($request->isMethod('get')) {

			return view($this->theme.'user.transfer.job_confirm', compact(['utr', 'transfer', 'enable_for']));
		}
		elseif ($request->isMethod('post')) {

			if (in_array('transfer', $enable_for)) {
				$purifiedData = Purify::clean($request->all());
			}

			$checkAmountValidate = $this->checkAmountValidate($transfer->amount, $transfer->currency_id, config('transactionType.transfer'), $transfer->charge);//1 = transfer

			if (!$checkAmountValidate['status']) {

				return back()->withInput()->with('alert', $checkAmountValidate['message']);
			}

			$checkRecipientValidate = $this->checkRecipientValidate($transfer->email);
			if (!$checkRecipientValidate['status']) {
				return back()->withInput()->with('alert', $checkRecipientValidate['message']);
			}
			/*
			 * Deduct money from Sender Wallet
			 * */

			$sender_wallet = updateWallet($transfer->sender_id, $transfer->currency_id, $transfer->transfer_amount, 0);
			/*
			 * Add money to receiver wallet
			 * */
			$receiver_wallet = updateWallet($transfer->receiver_id, $transfer->currency_id, $transfer->received_amount, 1);

			$transaction = new Transaction();
			$transaction->amount = $transfer->amount;
			$transaction->charge = $transfer->charge;
			$transaction->currency_id = $transfer->currency_id;
			$transfer->transactional()->save($transaction);
			$transfer->status = 1;
			$transfer->save();

			$escrow_id = session()->get('escrow_id');
			$escrow = Escrow::findOrFail($escrow_id);
			$escrow->paid = $transfer->amount;
			$escrow->payment_status = 1;
			$escrow->save();

			$receivedUserTO = $transfer->receiver;
			$msg = [
				'sender' => $user->name,
				'currency' => 'USD',
				'amount' => getAmount($transaction->amount),
				'transaction' => $transfer->utr,
			];
			$userAction = [
				"link" => route('user.transaction'),
				"icon" => "fas fa-user text-white"
			];
			$this->userPushNotification($receivedUserTO, 'TRANSFER_TO', $msg, $userAction);
			$this->userFirebasePushNotification($receivedUserTO,'TRANSFER_TO',$msg,route('user.transaction'));

			return redirect(route('user.transaction'))->with("success", "Your transfer has been submitted your remaining amount of money $sender_wallet");
		}
	}

	public function checkRecipientValidate($recipient)
	{
		$receiver = User::where('username', $recipient)
			->orWhere('email', $recipient)
			->first();

		if ($receiver && $receiver->id == Auth::id()) {
			$data['status'] = false;
			$data['message'] = 'Transfer not allowed to self email';
		} elseif ($receiver && $receiver->id != Auth::id()) {
			$data['status'] = true;
			$data['message'] = "User found. Are you looking for $receiver->name ?";
			$data['receiver'] = $receiver;
		} else {
			$data['status'] = false;
			$data['message'] = 'No user found';
		}

		return $data;
	}

	public function checkAmount(Request $request)
	{

		if ($request->ajax()) {
			$amount = $request->amount;
			$currency_id = $request->currency_id;
			$charge_from = $request->charge_from;
			$data = $this->checkAmountValidate($amount, $currency_id, $charge_from);
			return response()->json($data);
		}
	}

	public function checkAmountValidate($amount, $charge_from)
	{
		$chargesLimit = ChargeLimit::with('currency')->where('is_active',1)->first();

		$service_fee = ServiceFee::where('status',1)->where(function ($query) use($amount){
						$query->where('bid_start','<=',$amount)
								->where('bid_end','>=',$amount)
								->orWhereNull('bid_start');
		})->first();

		$user = auth()->user();
//		$wallet = Wallet::firstOrCreate(['user_id' => Auth::id(), 'currency_id' => $currency_id]);
		$limit = optional($chargesLimit->currency)->currency_type == 0 ? 8 : 2;
		$balance = getAmount($user->balance,$limit);
		$amount = getAmount($amount, $limit);
		$status = false;
		$charge = 0;
		$min_limit = 1;
		$max_limit = 9999;
		$percentage = 0;
		$percentage_charge = 0;

		if ($service_fee) {
			$percentage = getAmount($service_fee->percentage, $limit);
			$percentage_charge = getAmount(($amount * $percentage) / 100, $limit);
			$charge = getAmount($percentage_charge, $limit);

		}
		$transfer_amount = $amount;
		$received_amount = getAmount($amount - $charge, $limit);


		$remaining_balance = getAmount($balance - $transfer_amount, $limit);

		if ($amount < $min_limit || $amount > $max_limit) {
			$message = "minimum payment $min_limit and maximum payment limit $max_limit";
		} elseif ($transfer_amount > $balance) {
			$message = 'Does not have enough money to transfer';
		} else {
			$status = true;
			$message = "Remaining balance : $remaining_balance";
		}

		$data['status'] = $status;
		$data['message'] = $message;
		$data['percentage'] = $percentage;
		$data['percentage_charge'] = $percentage_charge;
		$data['balance'] = $balance;
		$data['transfer_amount'] = $transfer_amount;
		$data['received_amount'] = $received_amount;
		$data['remaining_balance'] = $remaining_balance;
		$data['charge'] = $charge;
		$data['charge_from'] = $charge_from;
		$data['amount'] = $amount;
		return $data;
	}

	public function gateway(Request $request)
	{
		$data['escrow'] = Escrow::find($request->id);
		if($data['escrow']->escorw_amount != 0)
		{
			$amount = $data['escrow']->escrow_amount;
		}
		else{
			$amount = $data['escrow']->budget;
		}

		$data['service_fee'] = ServiceFee::where('status',1)->where(function ($query) use(	$amount){
			$query->where('bid_start','<=',$amount)
				->where('bid_end','>=',$amount)->orWhereNull('bid_start');
		})->first();

		$charge = $amount * ($data['service_fee']->percentage)/100;
		$total = $amount - $charge;
		$data['gateways'] = Gateway::where('status',1)->get();

		return view($this->theme.'gateway',$data,compact('amount','charge','total'));
	}
}
