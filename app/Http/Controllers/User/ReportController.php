<?php

namespace App\Http\Controllers\User;

use App\Exports\ExportTransfer;
use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Traits\Upload;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
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
		$user = auth()->user();
		$data['listing_orders'] = Order::where('influencer_id',$user->id)->orWhere('user_id',$user->id)->with('listing')->latest()->paginate(config('basic.paginate'));

		return view ($this->theme.'user.report.index',$data);
	}

	public function orderFilter(Request $request)
	{
		$user_id = auth()->user()->id;

			if (($request->has('startDate') && $request->has('endDate')) || ($request->startDate)  ($request->type == 'listing')) {
				$startDate = $request->input('startDate');
				$endDate = $request->input('endDate');

				$listing_orders = Order::with('listing')->where(function ($query) use ($user_id) {
					$query->where('influencer_id', $user_id);
					$query->orWhere('user_id', $user_id);
				})->whereBetween('created_at', [$startDate, $endDate])->orWhereDate('created_at', $startDate)->latest()->paginate('basic.paginate')->map(function ($item) {
					$item->title = Str::limit(optional($item->listing)->title, 30);
					if ($item->file) {
						$item->filename = $item->file_name;
					} else {
						$item->filename = 'N\A';
					}
					$item->amount = basicControl()->currency_symbol . getAmount($item->amount);
					if ($item->status == 0) {
						$item->status = '<span class="badge bg-primary">Pending</span>';
					} elseif ($item->status == 1) {
						$item->status = '<span class="badge bg-primary">Ongoing</span>';
					} elseif ($item->status == 2) {
						$item->status = '<span class="badge bg-warning">Done</span>';
					} elseif ($item->status == 3) {
						$item->status = '<span class="badge bg-success">Completed</span>';
					} elseif ($item->status == 4) {
						$item->status = '<span class="badge bg-danger">Canceled</span>';
					}
					return $item;
				});
				return response()->json($listing_orders);
			}


			elseif (($request->has('startDate') && $request->has('endDate')) || ($request->startDate)  ($request->type == 'job')) {
				$startDate = $request->input('startDate');
				$endDate = $request->input('endDate');
				{
					$escrows = Escrow::with('hire')->whereHas('hire', function ($query) use ($user_id) {
						$query->where('client_id', $user_id);
						$query->orWhere('proposser_id', $user_id);
					})->whereBetween('created_at', [$startDate, $endDate])->orWhereDate('created_at', $startDate)->latest()->paginate(config('basic.paginate'))->map(function ($item) {
						if ($item->escrow_amount != 0) {
							$item->amount = basicControl()->currency_symbol . getAmount($item->escrow_amount);
						} else {
							$item->amount = basicControl()->currency_symbol . getAmount($item->budget);
						}

						if ($item->payment_status == 1) {
							$item->status = '<span class="badge bg-success">Paid</span>';
						} else {
							$item->status = '<span class="badge bg-danger">Unpaid</span>';
						}
						return $item;
					});

				}
				return response()->json($escrows);
			}

	}

	public function typeFilter(Request $request)
	{
		$user_id = auth()->user()->id;
		if($request->type == 'listing')
		{
			$listing_orders = Order::with('listing')->where(function ($query) use ($user_id){
				$query->where('influencer_id',$user_id);
				$query->orWhere('user_id',$user_id);
			})->latest()->get()->map(function ($item){

				$item->amount = basicControl()->currency_symbol.getAmount($item->amount);
				if ($item->status == 0)
				{
					$item->status = '<span class="badge bg-primary">Pending</span>';
				}
				elseif ($item->status == 1)
				{
					$item->status = '<span class="badge bg-primary">Ongoing</span>';
				}
				elseif ($item->status == 2)
				{
					$item->status = '<span class="badge bg-warning">Done</span>';
				}
				elseif ($item->status == 3)
				{
					$item->status = '<span class="badge bg-success">Completed</span>';
				}
				elseif($item->status == 4)
				{
					$item->status = '<span class="badge bg-danger">Canceled</span>';
				}
				return $item;
			});
			return response()->json($listing_orders);
		}
		else{
			$escrows = Escrow::with('hire')->whereHas('hire',function ($query) use($user_id){
					$query->where('client_id',$user_id);
					$query->orWhere('proposser_id',$user_id);
			})->latest()->paginate(config('basic.paginate'))->map(function ($item){
				if($item->escrow_amount !=0)
				{
					$item->amount = basicControl()->currency_symbol.getAmount($item->escrow_amount);
				}
				else{
					$item->amount = basicControl()->currency_symbol.getAmount($item->budget);
				}

				if($item->payment_status == 1)
				{
					$item->status = '<span class="badge bg-success">Paid</span>';
				}
				else{
					$item->status = '<span class="badge bg-danger">Unpaid</span>';
				}
				return $item;
			});
			return response()->json($escrows);
		}

	}

	public function escrowFilter(Request $request)
	{

		$user_id = auth()->user()->id;
		if (($request->has('startDate') && $request->has('endDate')) || ($request->startDate)) {
			$startDate = $request->input('startDate');
			$endDate = $request->input('endDate');

			$escrows = Escrow::whereHas('hire',function ($query) use ($user_id){
				$query->where('proposser_id',$user_id);
				$query->orWhere('client_id',$user_id);})
				->whereBetween('created_at',[$startDate,$endDate])->orWhereDate('created_at',$startDate)->latest()->get()
				->map(function ($item){
				$item->title = Str::limit(optional(optional($item->hire)->job)->title, 30);
				if($item->project_file)
				{
					$item->filename = $item->file_name;
				}
				else{
					$item->filename = 'N\A';
				}
				$item->amount = basicControl()->currency_symbol.getAmount($item->escrow_amount);

				return $item;
			});

		}
		return response()->json($escrows);
	}

	public function listingOrderExport(Request $request)
	{
		$data = $request->data;
		$fileName = $request->file_name ?? 'report';
		if (!$data) return;
		$headers = array_keys($request->data[0]);
		$footer = $request->footer_data;
		$export = new ExportTransfer($data, $headers, $footer);

		return Excel::download($export, $fileName.'.csv');
	}

	public function escrowExport(Request $request)
	{
		$data = $request->data;

		$fileName = $request->file_name ?? 'report';
		if (!$data) return;
		$headers = array_keys($request->data[0]);
		$footer = $request->footer_data;
		$export = new ExportTransfer($data, $headers, $footer);

		return Excel::download($export, $fileName.'.csv');
	}

}
