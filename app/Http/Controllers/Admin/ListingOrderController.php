<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ListingOrderController extends Controller
{
    public function list()
	{
		$orders = Order::with('listing','influencer','client')->latest()->paginate(config('basic.paginate'));
		return view('admin.listing.order.list',compact('orders'));
	}

	public function orderSearch(Request $request)
	{
		$search = $request->all();
		$orders = Order::when(isset($search['status']),function($query) use($search){
					return $query->where('status', $search['status']);
				})
				->when(isset($search['order_no']),function($query) use ($search){
					return $query->where('order_no','LIKE',"%{$search['order_no']}%");
				})
				->when(isset($search['package']),function($query) use($search){
					return $query->where('package_name','LIKE',"%{$search['package']}%");
				})->paginate(config('basic.paginate'));

		return view('admin.listing.order.list',compact('orders'));
	}

	public function remove(Request $request)
	{
		$remove = Order::findOrFail($request->id);
		$remove->delete();
		return back();

	}
}
