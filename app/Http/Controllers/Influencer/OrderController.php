<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Hire;
use App\Models\Level;
use App\Models\Listing;
use App\Models\Transfer;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Support\Str;
use function Sodium\increment;

class OrderController extends Controller
{
	use Upload,Notify;
	public $theme,$user;

	public function __construct()
	{
		$this->theme = template();
	}

	public function order()
	{
		if (Auth::check())
		{
			$proposser = auth()->user();
			$data['orders'] = Hire::where('proposser_id',$proposser->id)->where('is_hired',1)->with('job','client')->get();

			return view($this->theme.'user.order.order_list',$data);
		}
		return back()->with('error','Please login your account to check job details');
	}

	public function orderStore(Request $request)
	{
		$request->validate([
			'file' => 'required'
		]);
		$order = new Order();
		$order->hire_id = $request->hire_id;
		if ($request->file) {
			try {
				$file = $this->fileUpload($request->file, config('location.order.path'));
				if ($file) {
					$order->file = $file['path'] ?? null;
					$order->driver = $file['driver'] ?? null;
				}
			}
			catch (\Exception $e) {
				return back()->with('alert', 'File could not be uploaded');
			}
		}
		$order->save();
		return redirect()->back()->with('success','Succesfully delivered the order');
	}

	public function orderReceive($id)
	{
		return view($this->theme.'user.order.oder_receive');
	}

	public function listingOrder(Request $request)
	{
		$package_name = $request->input('package_name');
		$amount = $request->input('amount');
		return $amount;
	}
	public function listingOrderStore(Request $request)
	{
		$request->validate([
			'payment_type'=>'required',
			'delivery_date'=>'required|date|string'
		]);

		$order = new Order();
		$order->user_id = $request->user_id;
		$order->influencer_id = $request->influencer_id;
		$order->listing_id = $request->id;
		$order->package_name = $request->package_name;
		$order->order_no = '#odr-'.strRandom(6);
		$order->amount = $request->amount;
		$order->payment_type = $request->payment_type;
		$order->delivery_date = $request->delivery_date;

		$msg = [
			'package_name' => $order->package_name,
			'order_no' => $order->order_no,
			'amount' => basicControl()->currency_symbol.getAmount($order->amount),
		];

		$adminAction = [
			"link" => route('admin.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$userAction = [
			"link" => route('user.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];

		$influencer = User::findOrFail($request->influencer_id);

		$this->adminPushNotification('LISTING_ORDER', $msg, $adminAction);
		$this->userPushNotification($influencer, 'LISTING_ORDER', $msg, $userAction);
		$this->adminFirebasePushNotification('LISTING_ORDER',$msg,$adminAction);
		$this->userFirebasePushNotification($influencer,'LISTING_ORDER',$msg,$userAction);
		$currentDate = dateTime(Carbon::now());
		$this->sendMailSms($influencer, $type = 'LISTING_ORDER', [
			'sender' => auth()->user()->name,
			'receiver' => $influencer->name,
			'order_no' => $order->order_no,
			'amount' => getAmount($order->amount),

		]);

		$this->adminMail($type = 'LISTING_ORDER', [
			'sender' => auth()->user()->name,
			'receiver' => $influencer->name,
			'order_no' => $order->order_no,
			'amount' => basicControl()->currency_symbol.getAmount($order->amount),
		]);

		$order->save();

		$listing = Listing::findOrfail($request->id);

		if ($request->payment_type == 1) {

			session(['order_id'=>$order->id]);
			session(['order_amount'=>$order->amount]);
			session(['listing_id'=>$order->listing_id]);

			return redirect()->route('fund.initialize.listing',['slug'=>Str::slug($listing->title),'id'=>$listing->id]);
		}
		elseif($request->payment_type == 2)
		{

			$utr= $this->checkWalletPayment($order->amount,$order->user_id,$order->influencer_id);
			return redirect()->route('transfer.confirm.listing',$utr)->with('success','Transfer initiated successfully');
		}

		else {
			return back()->with('success', 'Order assign successfully');
		}
	}
	public function checkWalletPayment($amount,$user_id,$influencer_id)
	{
		$influencer = User::findOrFail($influencer_id);

		$transfer = new Transfer();
		$transfer->sender_id = $user_id;
		$transfer->receiver_id = $influencer_id;
		$transfer->amount = $amount;
		$transfer->transfer_amount = $amount;
		$transfer->received_amount = $amount;
		$transfer->note = 'Listing order payment from wallet';
		$transfer->email = $influencer->email;
		$transfer->status = 0;// 1 = success, 0 = pending
		$transfer->utr = (string)Str::uuid();
		$transfer->save();

		if($transfer->status == 1)
		{
			$influencer->balance += $amount;
			$client = User::findOrFail($user_id);
			$client->balance -= $amount;
			$influencer->save();
			$client->save();
		}
		return $transfer->utr;

	}

	public function listingOrderlist()
	{
		$user = auth()->user();
		$data['orders'] = Order::where('influencer_id',$user->id)->orWhere('user_id',$user->id)->latest()->paginate(config('basic.paginate'));
		return view($this->theme.'user.order.listing_orderList',$data);
	}
	public function listingOrderUpload(Request $request)
	{
		$order = Order::findOrFail($request->order_id);
		if ($request->file) {
			try {
				$name = 'file'.'_' . date('Y') . '-' . date('m') . '-' . date('d').'_'. strRandom(3);
				$file = $this->fileUpload($request->file, config('location.order.path'), null, $name);
				if ($file) {
					$order->file = $file['path'] ?? null;
					$order->driver = $file['driver'] ?? null;
					$order->file_name = $name;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'File could not be uploaded');
			}
		}
		$order->submit_date = now()->format('Y-m-d');
		$order->save();

		$msg = [
			'package_name' => $order->package_name,
			'order_no' => $order->order_no,
			'file_name' =>$order->file_name,
		];

		$adminAction = [
			"link" => route('admin.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$userAction = [
			"link" => route('user.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];

		$client = User::findOrFail($order->user_id);

		$this->adminPushNotification('LISTING_ORDER_FILE_SUBMIT', $msg, $adminAction);
		$this->userPushNotification($client, 'LISTING_ORDER_FILE_SUBMIT', $msg, $userAction);
		$this->adminFirebasePushNotification('LISTING_ORDER_FILE_SUBMIT',$msg,$adminAction);
		$this->userFirebasePushNotification($client,'LISTING_ORDER_FILE_SUBMIT',$msg,$adminAction);

		return back()->with('success','File uploaded successfully.');

	}

	public function listingOrderDetails($id)
	{
		$order = Order::with('listing','client')->findOrFail($id);
		return view($this->theme.'user.order.listing_orderDetails',compact('order'));
	}

	public function listingOrderAccept($id)
	{
		$order = Order::findOrFail($id);
		$order->status = 1;
		$order->save();

		$msg = [
			'order_no' => $order->order_no,
			'influencer' => $order->influencer->name,
		];

		$adminAction = [
			"link" => route('admin.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$userAction = [
			"link" => route('user.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$client = User::findOrFail($order->user_id);

		$this->adminPushNotification('LISTING_ORDER_ACCEPTED', $msg, $adminAction);
		$this->userPushNotification($client, 'LISTING_ORDER_ACCEPTED', $msg, $userAction);
		$this->userFirebasePushNotification();
		$this->adminFirebasePushNotification('LISTING_ORDER_ACCEPTED',$msg,$adminAction);
		$this->userFirebasePushNotification($client,'LISTING_ORDER_ACCEPTED',$msg,$userAction);
		return back()->with('success','Order accepted successfully.');
	}
	public function listingOrderCancel($id)
	{
		$order = Order::findOrFail($id);
		$order->status = 4;
		$order->save();

		$msg = [
			'order_no' => $order->order_no,
			'influencer' => $order->influencer->name,
		];
		$adminAction = [
			"link" => route('admin.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$userAction = [
			"link" => route('user.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$client = User::findOrFail($order->user_id);
		$this->adminPushNotification('LISTING_ORDER_CANCELED', $msg, $adminAction);
		$this->adminFirebasePushNotification('LISTING_ORDER_CANCELED',$msg,$adminAction);
		$this->userPushNotification($client, 'LISTING_ORDER_CANCELED', $msg, $userAction);
		$this->userFirebasePushNotification($client,'LISTING_ORDER_CANCELED',$msg,$userAction);
		return back()->with('success','Order cancel successfully.');
	}
	public function listingOrderDone($id)
	{
		$order = Order::findOrFail($id);
		if($order->status == 2)
		{
			return back()->with('alert','Order already done.');
		}
		$order->status = 2;
		$order->save();
		return back()->with('success','Order done successfully.');
	}

	public function listingOrderComplete($id)
	{
		$order = Order::with('listing')->findOrFail($id);
		if($order->status == 3)
		{
			return back()->with('alert','Order already completed.');
		}
		$order->status = 3;
		$order->save();
		if($order->status == 3)
		{
			$listing = Listing::findOrFail($order->listing_id);
			$listing->total_sell += 1;

			$listing->save();
			$user = User::findOrFail($order->influencer_id);
			$user->completed_order += 1;
			$user->save();

			$levels = Level::get();
			$nearestLevel = null;
			foreach ($levels as $level) {
				if ($level->minimum_complete_orders <= $user->completed_order) {
					if ($nearestLevel === null || $level->minimum_complete_orders > $nearestLevel->minimum_complete_orders) {
						$nearestLevel = $level;
					}
				}
				if ($level->minimum_earn_amount <= $user->balance) {
					if ($nearestLevel === null || $level->minimum_earn_amount > $nearestLevel->minimum_earn_amount) {
						$nearestLevel = $level;
					}
				}
			}
			if ($nearestLevel !== null) {
				$user->profile->seller_type = $nearestLevel->details->name;
				$user->profile->save();
			}
		}
		$msg = [
			'order_no' => $order->order_no,
			'client' =>$order->client->name,
		];
		$adminAction = [
			"link" => route('admin.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$userAction = [
			"link" => route('user.listing.order.list'),
			"icon" => "fas fa-user text-white"
		];
		$influencer = User::findOrFail($order->influencer_id);

		$this->adminPushNotification('LISTING_ORDER_COMPLETED', $msg, $adminAction);
		$this->adminFirebasePushNotification('LISTING_ORDER_COMPLETED',$msg,$adminAction);
		$this->userPushNotification($influencer, 'LISTING_ORDER_COMPLETED', $msg, $userAction);
		$this->userFirebasePushNotification($influencer,'LISTING_ORDER_COMPLETED',$msg,$userAction);

		return back()->with('success','Listing order completed successfully.');
	}
}
