<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Language;
use App\Models\Payout;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	use Upload, Notify;

	public function index()
	{
		$users = User::with('profile','profileInfo')->latest()->paginate(config('basic.paginate'));
		return view('admin.user.index', compact('users'));
	}

	public function inactiveUserList()
	{
		$users = User::where('status', 0)
			->with('profile')
			->latest()
			->paginate(config('basic.paginate'));
		return view('admin.user.inactive', compact('users'));
	}

	public function search(Request $request)
	{
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;
		$last_login_at = isset($search['last_login_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['last_login_at']) : 0;

		$active = isset($search['status']) ? preg_match("/active/", $search['status']) : 0;
		$inactive = isset($search['status']) ? preg_match("/inactive/", $search['status']) : 0;

		$users = User::with('profile')
			->when(isset($search['name']), function ($query) use ($search) {
				return $query->where('name', 'LIKE', "%{$search['name']}%");
			})
			->when(isset($search['email']), function ($query) use ($search) {
				return $query->where('email', 'LIKE', "%{$search['email']}%");
			})
			->when($active == 1, function ($query) use ($search) {
				return $query->where("status", 1);
			})
			->when($inactive == 1, function ($query) use ($search) {
				return $query->where("status", 0);
			})
			->when($created_date == 1, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			})
			->when($last_login_at == 1, function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->whereDate("last_login_at", $search['last_login_at']);
				});
			})
			->when(isset($search['phone']), function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->where('phone', 'LIKE', "%{$search['phone']}%");
				});
			})
			->latest()
			->paginate(config('basic.paginate'));
		$users->appends($search);
		return view('admin.user.index', compact('search', 'users'));
	}

	public function inactiveUserSearch(Request $request)
	{
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;
		$last_login_at = isset($search['last_login_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['last_login_at']) : 0;

		$active = isset($search['status']) ? preg_match("/active/", $search['status']) : 0;
		$inactive = isset($search['status']) ? preg_match("/inactive/", $search['status']) : 0;

		$users = User::where('status', 0)->with('profile')
			->when(isset($search['name']), function ($query) use ($search) {
				return $query->where('name', 'LIKE', "%{$search['name']}%");
			})
			->when(isset($search['email']), function ($query) use ($search) {
				return $query->where('email', 'LIKE', "%{$search['email']}%");
			})
			->when($active == 1, function ($query) use ($search) {
				return $query->where("status", 1);
			})
			->when($inactive == 1, function ($query) use ($search) {
				return $query->where("status", 0);
			})
			->when($created_date == 1, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			})
			->when($last_login_at == 1, function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->whereDate("last_login_at", $search['last_login_at']);
				});
			})
			->when(isset($search['phone']), function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->where('phone', 'LIKE', "%{$search['phone']}%");
				});
			})
			->latest()
			->paginate(config('basic.paginate'));
		$users->appends($search);
		return view('admin.user.inactive', compact('search', 'users'));
	}

	public function edit(Request $request, user $user)
	{
		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$languages = Language::get();
		if ($request->isMethod('get')) {
			$userId = $user->id;
			$countries = config('country');

			$addFundCount = Fund::where(['user_id' => $userId])->count();
			$payoutCount = Payout::where(['user_id' => $userId])->count();

			$transactionCount = [
				'fund' => $addFundCount,
				'payout' => $payoutCount
			];

			return view('admin.user.show', compact('user', 'userProfile', 'transactionCount', 'countries', 'languages'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'name' => 'required|min:3|max:100|string',
				'city' => 'nullable|min:3|max:32|string',
				'state' => 'nullable|min:3|max:32|string',
				'phone' => 'required|max:32',
				'address' => 'nullable|max:250',
				'password' => 'nullable|min:5|max:50',
				'username' => 'required|min:5|max:50|unique:users,username,' . $user->id,
				'email' => 'required|email|min:5|max:100|unique:users,email,' . $user->id,
				'language' => 'required|numeric|not_in:0'
			]);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;
			$user->name = $purifiedData->name;
			$user->username = $purifiedData->username;
			$user->email = $purifiedData->email;
			$user->status = $purifiedData->status;
			$user->language_id = $purifiedData->language;
			$user->email_verification = $purifiedData->email_verification;
			$user->sms_verification = $purifiedData->sms_verification;
			$userProfile->city = $purifiedData->city;
			$userProfile->state = $purifiedData->state;
			$userProfile->phone = $purifiedData->phone;
			$userProfile->phone_code = $purifiedData->phone_code;
			$userProfile->address = $purifiedData->address;

			$request->whenFilled('password', function ($input) use ($user, $purifiedData) {
				$user->password = bcrypt($purifiedData->password);
			});

			if ($request->file('profile_picture') && $request->file('profile_picture')->isValid()) {
				$extension = $request->profile_picture->extension();
				$profileName = strtolower($user->username . '.' . $extension);
				$userProfile->profile_picture = $this->uploadImage($request->profile_picture, config('location.user.path'), config('location.user.size'), $userProfile->profile_picture, $profileName);
			}

			$user->save();
			$userProfile->save();

			return back()->with('success', 'Profile Update Successfully');
		}
	}

	public function sendMailUser(Request $request, user $user = null)
	{
		if ($request->isMethod('get')) {
			return view('admin.user.sendMail', compact('user'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'subject' => 'required|min:5',
				'template' => 'required|min:10',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;
			$subject = $purifiedData->subject;
			$template = $purifiedData->template;

			if (isset($user)) {
				$this->mail($user, null, [], $subject, $template);
			} else {
				$users = User::all();
				foreach ($users as $user) {
					$this->mail($user, null, [], $subject, $template);
				}
			}
			return redirect(route('user-list'))->with('success', 'Email Send Successfully');
		}
	}

	public function userBalanceUpdate(Request $request, $id)
	{
		$userData = Purify::clean($request->all());
		if ($userData['balance'] == null) {
			return back()->with('error', 'Balance Value Empty!');
		} else {
			$control = (object)config('basic');
			$user = User::findOrFail($id);

			$trx = strRandom();

			if ($userData['add_status'] == "1") {
				$user->balance += $userData['balance'];
				$user->save();

				$fund = new Fund();
				$fund->user_id = $user->id;
				$fund->amount = $userData['balance'];
				$fund->admin_id = auth()->id();
				$fund->status = 1;
				$fund->email = $user->email ?? null;
				$fund->utr = $trx;
				$fund->save();

				$transaction = new Transaction();
				$transaction->amount = getAmount($userData['balance']);
				$transaction->charge = 0;
				$fund->transactional()->save($transaction);

				$msg = [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				];
				$action = [
					"link" => '#',
					"icon" => "fa fa-money-bill-alt text-white"
				];

				$this->userPushNotification($user, 'ADD_BALANCE', $msg, $action);
				$this->userFirebasePushNotification($user, 'ADD_BALANCE', $msg);
				$this->userFirebasePushNotification($user,'DEDUCTED_BALANCE',$msg);
				$this->sendMailSms($user, 'ADD_BALANCE', [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				]);
				return back()->with('success', 'Add balance successfully.');

			} else {

				if ($userData['balance'] > $user->balance) {
					return back()->with('error', 'Insufficient Balance to deducted.');
				}
				$user->balance -= $userData['balance'];
				$user->save();

				$fund = new Fund();
				$fund->user_id = $user->id;
				$fund->admin_id = auth()->id();
				$fund->amount = $userData['balance'];
				$fund->status = 1;
				$fund->email = $user->email ?? null;
				$fund->utr = $trx;
				$fund->save();

				$transaction = new Transaction();
				$transaction->amount = getAmount($userData['balance']);
				$transaction->charge = 0;
				$fund->transactional()->save($transaction);

				$msg = [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				];
				$action = [
					"link" => '#',
					"icon" => "fa fa-money-bill-alt text-white"
				];

				$this->userPushNotification($user, 'DEDUCTED_BALANCE', $msg, $action);

				$this->sendMailSms($user, 'DEDUCTED_BALANCE', [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx,
				]);
				return back()->with('success', 'Balance deducted Successfully.');
			}
		}
	}

	public function asLogin($id)
	{
		Auth::guard('web')->loginUsingId($id);
		return redirect()->route('user.dashboard');
	}
}
