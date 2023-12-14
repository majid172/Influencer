<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class TransactionController extends Controller
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

	public function index()
	{
		$user = Auth::user();
		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) {
			$morphTo->morphWith([
				Transfer::class => ['sender', 'receiver'],
				Payout::class => ['user'],
			]);
		}])
			->whereHasMorph('transactional',
				[
					Transfer::class,
					Payout::class,
				], function ($query, $type) use ($user) {
					if ($type === Transfer::class) {
						$query->where('sender_id', $user->id);
						$query->orWhere('receiver_id', $user->id);
					}
					elseif ($type === Payout::class) {
						$query->where('user_id',$user->id);
					}
				})
			->latest()
			->paginate();

		return view($this->theme . 'user.transaction.index', compact('transactions'));
	}

	public function search(Request $request)
	{

		$user = Auth::user();
		$search = $request->all();
		$type = 'App\Models\\'.$search['type'];
		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) {
			$morphTo->morphWith([
				Transfer::class => ['sender', 'receiver'],
			]);
		}])
			->whereHasMorph('transactional', [Transfer::class], function ($query, $type) use ($user, $search) {
				if ($type === Transfer::class) {
					$query->where(function ($query) use ($user) {
						$query->where('sender_id', $user->id)
							->orWhere('receiver_id', $user->id);
					});
				}
				if (isset($search['status'])) {
					$query->where('status', $search['status']);
				}
			})
			->when(isset($search['type']), function ($query) use($type){
				$query->where('transactional_type',$type);
			})

			->when(isset($search['startDate']) && isset($search['endDate']), function ($query) use ($search) {
				$query->whereBetween('created_at', [$search['startDate'], $search['endDate']]);
			})->latest()
			->paginate(config('basic.paginate'))->map(function ($item){

				$item->amount = getAmount($item->amount).basicControl()->base_currency;
				$item->type = str_replace('App\Models\\', '', $item->transactional_type);
				if($item->transactional->status)
				{
					$item->status = '<span class="badge bg-success">'.'Success'.'</span>';
				}
				else{
					$item->status = '<span class="badge bg-primary">'.'Pending'.'</span>';
				}
				$item->date = dateTime($item->created_at,'d M , Y ');
				return $item;
			});

		return response()->json($transactions);

	}

	public function _filter($request)
	{

		$user = Auth::user();
		$search = $request->all();

		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) {
			$morphTo->morphWith([
				Transfer::class => ['sender', 'receiver'],
			]);
		}])
			->whereHasMorph('transactional', [Transfer::class], function ($query, $type) use ($user, $search) {
				if ($type === Transfer::class) {
					$query->where(function ($query) use ($user) {
						$query->where('sender_id', $user->id)
							->orWhere('receiver_id', $user->id);
					});
				}

//				if (isset($search['status'])) {
//					$query->where('status', $search['status']);
//				}
			})
			->get();


		$data = [
			'user' => $user,
			'transactions' => $transactions,
			'search' => $search,
		];
		return $data;
	}

//	public function search(Request $request)
//	{
//		$filterData = $this->_filter($request);
//		$search = $filterData['search'];
//		$user = $filterData['user'];
//		$transactions = $filterData['transactions']
//			->latest()
//			->paginate();
//		$transactions->appends($filterData['search']);
//		return view($this->theme . 'user.transaction.index', compact('search', 'user', 'transactions'));
//	}
//
//	public function _filter($request)
//	{
//		$user = Auth::user();
//		$search = $request->all();
//		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;
//
//		if (isset($search['type'])) {
//			if ($search['type'] == 'Fund') {
//				$morphWith = [Fund::class => ['sender', 'receiver']];
//				$whereHasMorph = [Fund::class];
//			}
//		} else {
//			$morphWith = [
//				Fund::class => ['sender', 'receiver'],
//			];
//			$whereHasMorph = [
//				Fund::class,
//			];
//		}
//
//		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) use ($morphWith, $whereHasMorph) {
//			$morphTo->morphWith($morphWith);
//		}])
//			->whereHasMorph('transactional', $whereHasMorph, function ($query, $type) use ($search, $created_date, $user) {
//
//				if ($type === Fund::class) {
//					$query->where('user_id', $user->id);
//				}
//
//				$query->when(isset($search['utr']), function ($query) use ($search) {
//					return $query->where('utr', 'LIKE', $search['utr']);
//				})
//					->when(isset($search['min']), function ($query) use ($search) {
//						return $query->where('amount', '>=', $search['min']);
//					})
//					->when(isset($search['max']), function ($query) use ($search) {
//						return $query->where('amount', '<=', $search['max']);
//					})
//					->when($created_date == 1, function ($query) use ($search) {
//						return $query->whereDate("created_at", $search['created_at']);
//					});
//			}
//			);
//
//		$data = [
//			'user' => $user,
//			'transactions' => $transactions,
//			'search' => $search,
//		];
//		return $data;
//	}


//	Ajax search for statement period
	public function listSearch(Request $request)
	{
		$user = auth()->user();


		if (($request->has('startDate') && $request->has('endDate')) || ($request->startDate)) {
			$startDate = $request->input('startDate');
			$endDate = $request->input('endDate');

			$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) {
				$morphTo->morphWith([
					Transfer::class => ['sender', 'receiver'],
					Payout::class => ['user'],
				]);
			}])
				->whereHasMorph('transactional',
					[
						Transfer::class,
					], function ($query, $type) use ($user) {
						if ($type === Transfer::class) {
							$query->where('sender_id', $user->id);
							$query->orWhere('receiver_id', $user->id);
						} elseif ($type === Payout::class) {
							$query->where('user_id', $user->id);
						}
					})
				->whereBetween('created_at', [$startDate, $endDate])->orWhereDate('created_at', $startDate)
				->latest()
				->paginate()->map(function ($item) {
					$item->amount = (getAmount(optional($item->transactional)->amount));
					$item->utr = optional($item->transactional)->utr;
					$item->type = (str_replace('App\Models\\', '', $item->transactional_type));

					if ($item->transactional_type == Transfer::class) {
//						$item->status = ($item->transactional->status == 1) ? 'Success' : 'pending';
					} elseif ($item->transactional_type == Payout::class) {
						switch ($item->transactional->status) {
							case 0:
								$item->status = 'Pending';
								break;
							case 1:
								$item->status = 'Generate';
								break;
							case 2:
								$item->status = 'Payment Done';
								break;
							case 5:
								$item->status = 'Cancel';
								break;
//							case 6:
//								$item->status = 'failed';
//								break;
							default:
								'Failed';

						}
					}
					$item->created = $item->created_at;
					return $item;
				});


//			$dateSearch = Transfer::with(['sender', 'receiver', 'currency','depositable'])
//				->where(function ($query) use ($user_id) {
//					$query->where('sender_id', '=', $user_id);
//					$query->orWhere('receiver_id', '=', $user_id);
//				})
//				->whereBetween('created_at', [$startDate, $endDate])->orWhereDate('created_at',$startDate)->latest()->get()->map(function ($item){
//					$item->gateway = $item->depositable->gateway->name;
//					$item->transfer_amount = basicControl()->currency_symbol.getAmount($item->amount);
//					if($item->sender_id ==auth()->user()->id)
//					{
//						$item->type = '<span class="badge badge-success">Sent</span>';
//					}
//					elseif($item->receiver_id == auth()->user()->id)
//					{
//						$item->type = '<span class="badge badge-warning">Received</span>';
//					}
//					$item->statusBadge = ($item->status == 1)
//						? '<span class="badge badge-success">Success</span>'
//						: '<span class="badge badge-warning">Pending</span>';
//					return $item;
//				});

			return response()->json($transactions);

		}

//		if(($request->status == 1) || ($request->status == 0))
//		{
//			$status = $this->statusSearch($request->status,$user_id);
//			return response()->json($status);
//		}
	}


}
