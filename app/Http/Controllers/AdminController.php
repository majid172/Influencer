<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use App\Models\Payout;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\Deposit;
use App\Models\ProfileInfo;
use App\Models\Transaction;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Models\FirebaseNotify;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
	use Upload, Notify;

	public function index()
	{
		$basicControl = basicControl();
		$today = today();
		$dayCount = date('t', strtotime($today));

		$users = User::selectRaw('COUNT(id) AS totalUser')
			->selectRaw('COUNT((CASE WHEN created_at >= CURDATE()  THEN id END)) AS todayJoin')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS activeUser')
			->selectRaw('COUNT((CASE WHEN email_verified_at IS NOT NULL  THEN id END)) AS verifiedUser')
			->get()->makeHidden(['mobile', 'profile'])->toArray();

		$data['userRecord'] = collect($users)->collapse();
		$data['users'] = User::with('profile')->latest()->limit(5)->get();

		$transactions = Transaction::select('created_at')
			->whereMonth('created_at', $today)
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
			$dataDeposit[] = round($currentDeposit, $basicControl->fraction_number);
			$dataTransfer[] = round($currentTransfer, $basicControl->fraction_number);
			$dataPayout[] = round($currentPayout, $basicControl->fraction_number);
		}

		$data['labels'] = $labels;
		$data['dataDeposit'] = $dataDeposit;
		$data['dataTransfer'] = $dataTransfer;
		$data['dataPayout'] = $dataPayout;

		$deposits = Deposit::select('created_at')
			->where('status', 1)
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw("SUM(amount) as Deposit")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);

		$payouts = Payout::select('created_at')
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw("SUM(amount) as Payout")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);

		$data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

		$yearDeposit = [];
		$yearPayout = [];

		foreach ($data['yearLabels'] as $yearLabel) {
			$currentYearDeposit = 0;
			$currentYearPayout = 0;

			if (isset($deposits[$yearLabel])) {
				foreach ($deposits[$yearLabel] as $key => $deposit) {
					$currentYearDeposit += $deposit->Deposit;
				}
			}
			if (isset($payouts[$yearLabel])) {
				foreach ($payouts[$yearLabel] as $key => $payout) {
					$currentYearPayout += $payout->Payout;
				}
			}

			$yearDeposit[] = round($currentYearDeposit, $basicControl->fraction_number);
			$yearPayout[] = round($currentYearPayout, $basicControl->fraction_number);
		}

		$data['yearDeposit'] = $yearDeposit;
		$data['yearPayout'] = $yearPayout;

		$paymentMethods = Deposit::with('gateway:id,name')
			->whereYear('created_at', $today)
			->where('status', 1)
			->groupBy(['payment_method_id'])
			->selectRaw("SUM(amount) as totalAmount, payment_method_id")
			->get()
			->groupBy(['payment_method_id']);

		$paymentMethodeLabel = [];
		$paymentMethodeData = [];

		$paymentMethods = collect($paymentMethods)->collapse();
		foreach ($paymentMethods as $paymentMethode) {
			$currentPaymentMethodeData = 0;
			$currentPaymentMethodeLabel = optional($paymentMethode->gateway)->name ?? 'N/A';
			$currentPaymentMethodeData += $paymentMethode->totalAmount;

			$paymentMethodeLabel[] = $currentPaymentMethodeLabel;
			$paymentMethodeData[] = round($currentPaymentMethodeData, $basicControl->fraction_number);
		}

		$data['paymentMethodeLabel'] = $paymentMethodeLabel;
		$data['paymentMethodeData'] = $paymentMethodeData;
		$data['basicControl'] = $basicControl;

		$data['allJobs'] = JobPost::count();
		$data['pendingJobs'] = JobPost::where('status',0)->count();
		$data['approveJobs'] = JobPost::where('status',1)->count();
		$data['completedJobs'] = JobPost::where('status',2)->count();


		$data['jobs'] = collect(JobPost::selectRaw('COUNT(id) AS allJobs')
			->selectRaw('COUNT((CASE WHEN status = 0  THEN id END)) AS pendingJobs')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS approveJobs')
			->selectRaw('COUNT((CASE WHEN status = 2  THEN id END)) AS completedJobs')
			->get()->toArray())->collapse();


		$data['orders'] = collect(Order::selectRaw('COUNT(id) AS total')
			->selectRaw('COUNT((CASE WHEN status = 0  THEN id END)) AS pending')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS approved')
			->selectRaw('COUNT((CASE WHEN status = 2  THEN id END)) AS done')
			->selectRaw('COUNT((CASE WHEN status = 3  THEN id END)) AS completed')
			->selectRaw('COUNT((CASE WHEN status = 4  THEN id END)) AS canceled')
			->get()->toArray())->collapse();

		$firebaseNotify = FirebaseNotify::first();

		return view('admin.home', $data, compact('firebaseNotify'));
	}

	public function changePassword(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('admin.auth.passwords.change');
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'current_password' => 'required|min:5',
				'password' => 'required|min:5|confirmed',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$user = Auth::user();
			$purifiedData = (object)$purifiedData;

			if (!Hash::check($purifiedData->current_password, $user->password)) {
				return back()->withInput()->withErrors(['current_password' => 'current password did not match']);
			}

			$user->password = bcrypt($purifiedData->password);
			$user->save();
			return back()->with('success', 'Password changed successfully');
		}
	}


	public function saveToken(Request $request)
	{
		$admin = auth()->user();
		$admin->fcm_token = $request->token;
		$admin->save();
		return response()->json(['token saved successfully.']);
	}

	public function profileApprove($id)
	{
		$Approve = ProfileInfo::where('user_id', $id)->update(['status' => 1]);
		$user = User::findOrFail($id);

		$this->sendMailSms($user, 'USER_PROFILE_APPROVED', [
			'user_name' => $user->username,
		]);
		$msg = [
			'user_name' => $user->username,
		];
		$action = [
			"link" => route('user.profile'),
			"icon" => "fas fa-money-bill-alt text-white"
		];

		$this->userPushNotification($user, 'USER_PROFILE_APPROVED', $msg, $action);
		// for Firebase/Push Notification
		$firebaseAction = route('user.profile');
		$this->userFirebasePushNotification($user, 'USER_PROFILE_APPROVED', $msg, $firebaseAction);

		return back()->with('success', 'Profile Approved Successfully.');
	}


	public function profilePending($id)
	{
		$pending = ProfileInfo::where('user_id', $id)->update(['status' => 0]);
		$user = User::findOrFail($id);

		$this->sendMailSms($user, 'USER_PROFILE_MAKE_PENDING', [
			'user_name' => $user->username,
		]);

		$msg = [
			'user_name' => $user->username,
		];
		$action = [
			"link" => route('user.profile'),
			"icon" => "fas fa-money-bill-alt text-white"
		];

		$this->userPushNotification($user, 'USER_PROFILE_MAKE_PENDING', $msg, $action);

		$firebaseAction = route('user.profile');
		$this->userFirebasePushNotification($user, 'USER_PROFILE_MAKE_PENDING', $msg, $firebaseAction);

		return back()->with('success', 'Profile Marked As Pending Successfully.');
	}

}
