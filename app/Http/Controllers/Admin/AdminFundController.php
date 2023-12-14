<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Gateway;
use Illuminate\Http\Request;

class AdminFundController extends Controller
{
	public function index()
	{
		$gateways = Gateway::orderBy('code', 'ASC')->get();
		$funds = Fund::with(['sender', 'sender.profile', 'receiver', 'receiver.profile'])
			->latest()->paginate();
		return view('admin.fund.index', compact('funds', 'gateways'));
	}

	public function search(Request $request)
	{
		$filterData = $this->_filter($request);
		$search = $filterData['search'];
		$gateways = $filterData['gateways'];
		$funds = $filterData['funds']
			->latest()
			->paginate();
		$funds->appends($filterData['search']);
		return view('admin.fund.index', compact('search', 'funds', 'gateways'));
	}

	public function _filter($request)
	{
		$gateways = Gateway::orderBy('code', 'ASC')->get();
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;

		$funds = Fund::with(['sender', 'sender.profile', 'receiver', 'receiver.profile'])
			->when(isset($search['sender']), function ($query) use ($search) {
				return $query->whereHas('sender', function ($qry) use ($search) {
					$qry->where('username', 'LIKE', "{$search['receiver']}")
						->orWhere('name', 'LIKE', "%{$search['sender']}%");
				});
			})
			->when(isset($search['receiver']), function ($query) use ($search) {
				return $query->whereHas('receiver', function ($qry) use ($search) {
					$qry->where('username', 'LIKE', "{$search['receiver']}")
						->orWhere('name', 'LIKE', "%{$search['receiver']}%");
				});
			})
			->when(isset($search['gateway_id']), function ($query) use ($search) {
				return $query->whereHas('depositable', function ($qry) use ($search) {
					$qry->where('payment_method_id', $search['gateway_id']);
				});
			})
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
			'gateways' => $gateways,
			'search' => $search,
			'funds' => $funds,
		];
		return $data;
	}

	public function showByUser($userId)
	{
		$gateways = Gateway::orderBy('code', 'ASC')->get();
		$funds = Fund::with(['sender', 'sender.profile', 'receiver', 'receiver.profile'])
			->where('user_id', $userId)
			->latest()->paginate();
		return view('admin.fund.index', compact('funds', 'gateways'));
	}

	public function searchByUser(Request $request, $userId)
	{
		$filterData = $this->_filter($request);
		$search = $filterData['search'];
		$funds = $filterData['funds']
			->where('user_id', $userId)
			->latest()
			->paginate();
		$funds->appends($filterData['search']);
		return view('admin.fund.index', compact('search', 'funds'));
	}
}
