<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
	public function index()
	{
		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) {
			$morphTo->morphWith([
				Transfer::class => ['sender', 'receiver'],
			]);
		}])
			->whereHasMorph('transactional',
				[
					Transfer::class,
				])
			->latest()
			->paginate();

		return view('admin.transaction.index', compact('transactions'));
	}

	public function search(Request $request)
	{
		$filterData = $this->_filter($request);
		$search = $filterData['search'];
		$transactions = $filterData['transactions']
			->latest()
			->paginate();
		$transactions->appends($filterData['search']);
		return view('admin.transaction.index', compact('search', 'transactions'));
	}

	public function _filter($request)
	{
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;

		if (isset($search['type'])) {
			if ($search['type'] == 'Fund') {
				$morphWith = [Fund::class => ['sender', 'receiver']];
				$whereHasMorph = [Fund::class];
			}
		} else {
			$morphWith = [
				Fund::class => ['sender', 'receiver'],
			];
			$whereHasMorph = [
				Fund::class,
			];
		}

		$transactions = Transaction::with(['transactional' => function (MorphTo $morphTo) use ($morphWith, $whereHasMorph) {
			$morphTo->morphWith($morphWith);
		}])
			->whereHasMorph('transactional', $whereHasMorph, function ($query, $type) use ($search, $created_date) {
				$query->when(isset($search['utr']), function ($query) use ($search) {
					return $query->where('utr', 'LIKE', $search['utr']);
				})
					->when(isset($search['email']), function ($query) use ($search, $type) {
						if ($type !== Exchange::class) {
							return $query->where('email', 'LIKE', "%{$search['email']}%");
						}
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
			}
			);

		$data = [
			'transactions' => $transactions,
			'search' => $search,
		];
		return $data;
	}
}
