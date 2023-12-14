<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Payout;
use Carbon\Carbon;
use App\Traits\Upload;
use App\Models\Transaction;
use App\Models\JobProposal;
use Illuminate\Http\Request;
use App\Models\FirebaseNotify;
use App\Models\NotifyTemplate;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HomeController extends Controller
{
	use Upload;

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


	public function index()
	{
		$basic = basicControl();
		$fraction = $basic->fraction_number;
		$user = Auth::user();
		$today = today();
		$dayCount = date('t', strtotime($today));

		$transactions = Transaction::select('created_at')
			->whereMonth('created_at', $today)
			->with(['transactional' => function (MorphTo $morphTo) {
				$morphTo->morphWith([
					Transfer::class => ['sender', 'receiver'],
					Payout::class => ['user'],
				]);
			}])
			->whereHasMorph('transactional',
				[
					Transfer::class,
					Payout::class,
				],
				function ($query, $type) use ($user) {
					if ($type === Transfer::class) {
						$query->where('sender_id', $user->id)
							->orWhere('receiver_id', $user->id);
					}
					elseif ($type === Payout::class)
					{
						$query->where('user_id',$user->id);
					}
				})
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%j')")])
			->selectRaw("SUM(CASE WHEN transactional_type like '%Deposit' THEN amount ELSE 0 END) as Deposit")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Transfer' THEN amount ELSE 0 END) as Transfer")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Payout' THEN amount ELSE 0 END) as Payout")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('j');
			}]);


		$labels = [];
		$dataDeposit = [];
		$dataTransfer = [];
		$dataPayout = [];
		for ($i = 1; $i <= $dayCount; $i++) {
			$labels[] = date('jS M', strtotime(date('Y/m/') . $i));
			$currentDeposit = 0;
			$currentTransfer = 0;
			$currentPayout = 0;
			if (isset($transactions[$i])) {
				foreach ($transactions[$i] as $key => $transaction) {
					$currentDeposit += $transaction->Deposit;
					$currentTransfer += $transaction->Transfer;

					$currentPayout += $transaction->Payout;
				}
			}
			$dataDeposit[] = round($currentDeposit, $fraction);
			$dataTransfer[] = round($currentTransfer, $fraction);

			$dataPayout[] = round($currentPayout, $fraction);
		}

		$data['basic'] = $basic;
		$data['labels'] = $labels;
		$data['dataDeposit'] = $dataDeposit;
		$data['dataTransfer'] = $dataTransfer;
		$data['dataPayout'] = $dataPayout;


		$user = $this->user;

		$data['jobProposal'] = JobProposal::with('job')->whereHas('job', function ($query) use ($user) {
			$query->where('creator_id', $user->id);
		})->count();

		$data['complete_job'] = JobProposal::where('proposer_id', $user->id)->whereHas('job', function ($query) {
			$query->where('status', 2);
		})->count();

		$user_id = $user->id;

		$data['active_orders'] = Listing::where('user_id', $user_id)
			->with(['orders' => function ($query) use ($user_id) {
				$query->where('influencer_id', $user_id);
			}])
			->whereHas('orders', function ($q) use ($user_id) {
				$q->where('influencer_id', $user_id)->where('status', 1);
			})
			->get();

		$data['complete_order'] = Listing::where('user_id', $this->user->id)
			->with(['orders' => function ($query) use ($user_id) {
				$query->where('influencer_id', $user_id);
			}])
			->whereHas('orders', function ($q) use ($user_id) {
				$q->where('influencer_id', $user_id)->where('status', 3);
			})
			->get();

		$data['cancel_order'] = Listing::where('user_id', $this->user->id)
			->with(['orders' => function ($query) use ($user_id) {
				$query->where('influencer_id', $user_id);
			}])
			->whereHas('orders', function ($q) use ($user_id) {
				$q->where('influencer_id', $user_id)->where('status', 4);
			})
			->get();

		$query = Transfer::where('receiver_id', $user->id)->whereRaw('MONTH(created_at) = ?', [now()->month]);
		$data['avg_selling'] = $query->avg('amount');
		$firebaseNotify = FirebaseNotify::first();
//		transfer chart
		$data['transfers'] = Transfer::where('status', 1)
			->where(function ($query) use ($user) {
				$query->where('receiver_id', $user->id)
					->orWhere('sender_id', $user->id);
			})
			->get();

		$currentMonthStart = Carbon::now()->startOfMonth();
		$currentMonthEnd = Carbon::now()->endOfMonth();

		$dailySendingData = [];
		$dailyReceivingData = [];

		foreach ($data['transfers'] as $transfer) {
			$monthly = Carbon::parse($transfer->created_at);
			$monthlyDate = $monthly->toDateString();
			$amount = (float)$transfer->amount;

			if ($monthly->between($currentMonthStart, $currentMonthEnd)) {
				if ($transfer->sender_id == $user->id) {

					if (!isset($dailySendingData[$monthlyDate])) {
						$dailySendingData[$monthlyDate] = $amount;
					} else {
						$dailySendingData[$monthlyDate] += $amount;
					}
				} elseif ($transfer->receiver_id == $user->id) {

					if (!isset($dailyReceivingData[$monthlyDate])) {
						$dailyReceivingData[$monthlyDate] = $amount;
					} else {
						$dailyReceivingData[$monthlyDate] += $amount;
					}
				}
			}
		}

		$data['dateSending'] = array_keys($dailySendingData);
		$data['dateReceiving'] = array_keys($dailyReceivingData);
		$data['sendingValues'] = array_values($dailySendingData);
		$data['receivingValues'] = array_values($dailyReceivingData);


		$data['order'] = Order::where('influencer_id', $user->id)->orWhere('user_id', $user->id)->get();
		$orderChart = $this->orderChart($data['order']);

		return view($this->theme . 'user.home', $data, compact('firebaseNotify', 'user', 'basic', 'orderChart'));


	}

	public function getTransactionData(Request $request)
	{
		$start = $request->start;
		$end = $request->end;

		$start = substr($start, 0, strpos($start, 'GMT'));
		$end = substr($end, 0, strpos($end, 'GMT'));

		$startDateTime = new \DateTime($start);
		$endDateTime = new \DateTime($end);

		$user = Auth::user();

		$transactions = Transaction::select('created_at')
			->whereBetween('created_at', [$startDateTime, $endDateTime])
			->with(['transactional' => function (MorphTo $morphTo) {
				$morphTo->morphWith([
					Transfer::class => ['sender', 'receiver'],
					Payout::class => ['user'],
				]);
			}])
			->whereHasMorph('transactional', [Transfer::class, Payout::class], function ($query, $type) use ($user) {
				if ($type === Transfer::class) {
					$query->where(function ($query) use ($user) {
						$query->where('sender_id', $user->id)
							->orWhere('receiver_id', $user->id);
					});
				} elseif ($type === Payout::class) {
					$query->where('user_id', $user->id);
				}
			})
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%j')")])
			->selectRaw("SUM(CASE WHEN transactional_type like '%Deposit' THEN amount ELSE 0 END) as Deposit")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Transfer' THEN amount ELSE 0 END) as Transfer")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Payout' THEN amount ELSE 0 END) as Payout")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('j');
			}]);

		$labels = [];
		$dataDeposit = [];
		$dataTransfer = [];
		$dataPayout = [];

		$basic = basicControl();
		$fraction = $basic->fraction_number;
		for ($i = 1; $i <= $endDateTime->format('j'); $i++) {
			$labels[] = date('jS M', strtotime(date('Y/m/') . $i));
			$currentDeposit = 0;
			$currentTransfer = 0;
			$currentPayout = 0;

			if (isset($transactions[$i])) {
				foreach ($transactions[$i] as $key => $transaction) {
					$currentDeposit += $transaction->Deposit;
					$currentTransfer += $transaction->Transfer;
					$currentPayout += $transaction->Payout;
				}
			}

			$dataDeposit[] = round($currentDeposit, $fraction);
			$dataTransfer[] = round($currentTransfer, $fraction);
			$dataPayout[] = round($currentPayout, $fraction);
		}

		$data['labels'] = $labels;
		$data['dataDeposit'] = $dataDeposit;
		$data['dataTransfer'] = $dataTransfer;
		$data['dataPayout'] = $dataPayout;

		return response()->json($data);
	}

	// for Firebase Notification
	public function settingNotify()
	{
		$data['templates'] = NotifyTemplate::where('firebase_notify_status', 1)->where('notify_for', 0)->get()->unique('template_key');
		return view($this->theme . 'user.setting.notifyTemplate', $data);
	}

	public function settingNotifyUpdate(Request $request)
	{
		$user = auth()->user();
		$user->notify_active_template = $request->access;
		$user->save();

		session()->flash('success', 'Updated Successfully');
		return back();
	}


	public function saveToken(Request $request)
	{
		auth()->user()->update(['fcm_token' => $request->token]);
		return response()->json(['token saved successfully.']);
	}


	public function orderChart($orders)
	{

		$activeOrdersCount = $orders->where('status', 1)->count();
		$completeOrdersCount = $orders->where('status', 3)->count();
		$canceledOrdersCount = $orders->where('status', 4)->count();

		return [
			'activeOrdersCount' => $activeOrdersCount,
			'completeOrdersCount' => $completeOrdersCount,
			'canceledOrdersCount' => $canceledOrdersCount,
		];
	}
}
