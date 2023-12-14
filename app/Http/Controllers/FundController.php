<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Escrow;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Listing;
use App\Models\Order;
use App\Models\Template;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class FundController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
			return $next($request);
		});
		$this->theme = template();
	}

	public $user;

	public function index()
	{
		$userId = Auth::id();
		$funds = Fund::with(['sender', 'receiver', 'depositable'])
			->where('user_id', $userId)
			->latest()->paginate(config('basic.paginate'));

		return view($this->theme . 'user.fund.index', compact('funds'));
	}

	public function search(Request $request)
	{
		$filterData = $this->_filter($request);
		$search = $filterData['search'];
		$userId = $filterData['userId'];
		$funds = $filterData['funds']
			->where('user_id', $userId)
			->latest()
			->paginate();
		$funds->appends($filterData['search']);
		return view($this->theme . 'user.fund.index', compact('search', 'funds'));
	}

	public function _filter($request)
	{
		$userId = Auth::id();
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;

		$funds = Fund::with('sender', 'receiver')
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
			->when($created_date == 1, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			});

		$data = [
			'userId' => $userId,
			'search' => $search,
			'funds' => $funds,
		];
		return $data;
	}

	public function requested()
	{
		$userId = Auth::id();
		$funds = Deposit::with(['receiver'])
			->where('user_id', $userId)
			->where('payment_method_id', '>', 999)
			->whereIn('status', [2, 3])
			->latest()->paginate(config('basic.paginate'));

		return view($this->theme . 'user.fund.requested', compact('funds'));
	}

	public function initialize(Request $request)
	{
		if ($request->isMethod('get')) {
			$methods = Gateway::orderBy('sort_by', 'ASC')->get();
			$template = Template::where('section_name', 'add-fund')->firstOrFail();
			return view($this->theme . 'user.fund.create', compact('methods', 'template'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validationRules = [
				'amount' => 'required|numeric|min:1|not_in:0',
				'methodId' => 'required|integer|min:1|not_in:0',
			];

			$validate = Validator::make($purifiedData, $validationRules);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$amount = $purifiedData->amount;
			$methodId = $purifiedData->methodId;

			$checkAmountValidate = $this->checkAmountValidate($amount, $methodId);

			if (!$checkAmountValidate['status']) {
				return back()->withInput()->with('alert', $checkAmountValidate['message']);
			}

			$method = Gateway::findOrFail($methodId);
			$user = Auth::user();
			$deposit = new Deposit();
			$deposit->user_id = $user->id;
			$deposit->payment_method_id = $methodId;
			$deposit->amount = $amount;
			$deposit->percentage = $checkAmountValidate['percentage'];
			$deposit->charge_percentage = $checkAmountValidate['percentage_charge'];
			$deposit->charge_fixed = $checkAmountValidate['fixed_charge'];
			$deposit->charge = $checkAmountValidate['charge'];
			$deposit->payable_amount = $checkAmountValidate['payable_amount'] * $checkAmountValidate['convention_rate'];
			$deposit->utr = Str::random(16);
			$deposit->status = 0;// 1 = success, 0 = pending
			$deposit->email = $user->email;
			$deposit->payment_method_currency = $method->currency;
			$deposit->depositable_type = Fund::class;
			$deposit->save();
			return redirect(route('deposit.confirm', $deposit->utr));
		}
	}

	public function initializeJob(Request $request,$escrow_id)
	{
		if ($request->isMethod('get')) {
			$methods = Gateway::orderBy('sort_by', 'ASC')->get();
			$escrow = Escrow::findOrFail($escrow_id);

			return view($this->theme.'user.milestone.checkout',compact('escrow_id','methods','escrow'));
		}
		elseif ($request->isMethod('post')) {

			$purifiedData = Purify::clean($request->all());
			$validationRules = [
				'amount' => 'required|numeric|min:1|not_in:0',
				'methodId' => 'required|integer|min:1|not_in:0',
			];

			$validate = Validator::make($purifiedData, $validationRules);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}

			$purifiedData = (object)$purifiedData;
			$amount = $purifiedData->amount;
			$methodId = $purifiedData->methodId;

			$checkAmountValidateListing = $this->checkAmountValidateListing($amount, config('transactionType.deposit'), $methodId);


			$escrow = Escrow::where('id',$escrow_id)->firstOrFail();
			$method = Gateway::where('status',1)->findOrFail($methodId);

			$utr = (string)Str::uuid();
			$transfer = new Transfer();
			$transfer->sender_id = $this->user->id;
			$transfer->receiver_id = $escrow->hire->proposser_id;
			$transfer->amount = $amount;
			$transfer->received_amount = $amount - $checkAmountValidateListing['charge'];
			$transfer->email = $this->user->email;
			$transfer->utr = $utr;
			$transfer->save();

			$deposit = new Deposit();
			$deposit->user_id = $this->user->id;
			$deposit->payment_method_id = $methodId;
			$deposit->amount = $amount;
			$deposit->percentage = $checkAmountValidateListing['percentage'];
			$deposit->charge_percentage = $checkAmountValidateListing['percentage_charge'];
			$deposit->charge_fixed = $checkAmountValidateListing['fixed_charge'];
			$deposit->charge = $checkAmountValidateListing['charge'];
			$deposit->payable_amount = $checkAmountValidateListing['payable_amount'] * $checkAmountValidateListing['convention_rate'];
			$deposit->utr = $utr;
			$deposit->status = 0;// 1 = success, 0 = pending
			$deposit->email = $this->user->email;
			$deposit->payment_method_currency = $method->currency;
			$deposit->depositable_type = Transfer::class;
			$deposit->depositable_id = $transfer->id;
			$deposit->save();

			$escrow->paid = $amount;
			$escrow->payment_status = 1;
			$escrow->save();
			return redirect(route('payment.process', $deposit->utr));
		}
	}

	public function initializeListing(Request $request,$slug,$id)
	{
		if ($request->isMethod('get')) {
			$methods = Gateway::orderBy('sort_by', 'ASC')->get();
			$amount = session('order_amount');
			$order_id = session('order_id');
			$listing_title = Str::slug($slug);
			$listing_id = $id;

			return view($this->theme.'user.listing.checkout',compact('amount','listing_id','listing_title','methods','order_id'));
		}
		elseif ($request->isMethod('post')) {

			$purifiedData = Purify::clean($request->all());
			$validationRules = [
				'amount' => 'required|numeric|min:1|not_in:0',
				'methodId' => 'required|integer|min:1|not_in:0',
			];

			$validate = Validator::make($purifiedData, $validationRules);
			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput();
			}
			$purifiedData = (object)$purifiedData;
			$amount = $purifiedData->amount;
			$methodId = $purifiedData->methodId;
			$checkAmountValidateListing = $this->checkAmountValidateListing($amount, config('transactionType.deposit'), $methodId);

			$listing = Listing::where('id',$id)->firstOrFail();
			$method = Gateway::where('status',1)->findOrFail($methodId);
			$utr = (string)Str::uuid();
			$transfer = new Transfer();
			$transfer->sender_id = $this->user->id;
			$transfer->receiver_id = $listing->user_id;
			$transfer->amount = $amount;
			$transfer->received_amount = $amount - $checkAmountValidateListing['charge'];
			$transfer->email = $this->user->email;
			$transfer->utr = $utr;
			$transfer->save();

			$order = Order::findOrFail($purifiedData->order_id);
			$order->payable_amount = $amount;
			$order->save();

			$deposit = new Deposit();
			$deposit->user_id = $this->user->id;
			$deposit->payment_method_id = $methodId;
			$deposit->amount = $amount;
			$deposit->percentage = $checkAmountValidateListing['percentage'];
			$deposit->charge_percentage = $checkAmountValidateListing['percentage_charge'];
			$deposit->charge_fixed = $checkAmountValidateListing['fixed_charge'];
			$deposit->charge = $checkAmountValidateListing['charge'];
			$deposit->payable_amount = $checkAmountValidateListing['payable_amount'] * $checkAmountValidateListing['convention_rate'];
			$deposit->utr = $utr;
			$deposit->status = 0;// 1 = success, 0 = pending
			$deposit->email = $this->user->email;
			$deposit->payment_method_currency = $method->currency;
			$deposit->depositable_type = Transfer::class;
			$deposit->depositable_id = $transfer->id;
			$deposit->save();
			return redirect(route('payment.process', $deposit->utr));

		}
	}

	public function checkAmountValidateListing($amount,$transaction_type_id, $methodId)
	{
		$gateway = Gateway::where('status', 1)->find($methodId);
		$balance = auth()->user()->balance;
		$status = false;
		$charge = 0;
		$min_limit = 0;
		$max_limit = 0;
		$fixed_charge = 0;
		$percentage = 0;
		$percentage_charge = 0;

		$percentage = $gateway->percentage_charge;
		$percentage_charge = ($amount * $percentage) / 100;
		$fixed_charge = $gateway->fixed_charge;
		$min_limit = $gateway->min_amount;
		$max_limit = $gateway->max_amount;
		$charge = $percentage_charge + $fixed_charge;

		//Total amount with all fixed and percent charge for deduct
		$payable_amount = $amount + $percentage_charge + $fixed_charge ;
		$new_balance = $balance - $payable_amount;

		//Currency inactive
		if ($min_limit == 0 && $max_limit == 0) {
			$message = "Payment method not available for this transaction";
		} elseif ($amount < $min_limit || $amount > $max_limit) {
			$message = "minimum payment $min_limit and maximum payment limit $max_limit";
		} else {
			$status = true;
			$message = "Updated balance : $new_balance";
		}

		$data['status'] = $status;
		$data['message'] = $message;
		$data['fixed_charge'] = $fixed_charge;
		$data['percentage'] = $percentage;
		$data['percentage_charge'] = $percentage_charge;
		$data['min_limit'] = $min_limit;
		$data['max_limit'] = $max_limit;
		$data['balance'] = $balance;
		$data['payable_amount'] = $payable_amount;
		$data['new_balance'] = $new_balance;
		$data['charge'] = $charge;
		$data['amount'] = $amount;
		$data['convention_rate'] = $gateway->convention_rate;
		return $data;
	}

	public function checkAmountValidate($amount, $methodId)
	{
		$gateway = Gateway::where('status', 1)->find($methodId);

		$balance = auth()->user()->balance;
		$status = false;
		$charge = 0;
		$min_limit = 0;
		$max_limit = 0;
		$fixed_charge = 0;
		$percentage = 0;
		$percentage_charge = 0;

		$percentage = $gateway->percentage_charge;
		$percentage_charge = ($amount * $percentage) / 100;
		$fixed_charge = $gateway->fixed_charge;
		$min_limit = $gateway->min_amount;
		$max_limit = $gateway->max_amount;
		$charge = $percentage_charge + $fixed_charge;

		//Total amount with all fixed and percent charge for deduct
		$payable_amount = $amount + $charge;
		$new_balance = $balance + $amount;

		//Currency inactive
		if ($min_limit == 0 && $max_limit == 0) {
			$message = "Payment method not available for this transaction";
		} elseif ($amount < $min_limit || $amount > $max_limit) {
			$message = "minimum payment $min_limit and maximum payment limit $max_limit";
		} else {
			$status = true;
			$message = "Updated balance : $new_balance";
		}

		$data['status'] = $status;
		$data['message'] = $message;
		$data['fixed_charge'] = $fixed_charge;
		$data['percentage'] = $percentage;
		$data['percentage_charge'] = $percentage_charge;
		$data['min_limit'] = $min_limit;
		$data['max_limit'] = $max_limit;
		$data['balance'] = $balance;
		$data['payable_amount'] = $payable_amount;
		$data['new_balance'] = $new_balance;
		$data['charge'] = $charge;
		$data['amount'] = $amount;
		$data['convention_rate'] = $gateway->convention_rate;

		return $data;
	}

	public function jobGateway(Request $request)
	{
		$methodId = $request->methodId;
		$gateway = Gateway::findOrFail($methodId);
		return response()->json($gateway);
	}

	public function listingGateway(Request $request)
	{
		$methodId = $request->methodId;
		$gateway = Gateway::findOrFail($methodId);
		return response()->json($gateway);
	}
}
