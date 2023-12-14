<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Fund;
use App\Models\User;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Template;
use App\Models\Transaction;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NotifyTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	use RegistersUsers;

	public function showRegistrationForm(Request $request)
	{
		$referral = $request->referral;
		$info = json_decode(json_encode(getIpInfo()), true);
		$country_code = null;
		if (!empty($info['code'])) {
			$country_code = $info['code'][0];
		}
		$countries = config('country');
		$template = Template::where('section_name', 'register')->first();
		return view(template() . 'auth.register', compact('countries', 'referral', 'country_code', 'template'));
	}

	protected $redirectTo = RouteServiceProvider::HOME;

	public function __construct()
	{
		$this->middleware('guest');
	}

	protected function validator(array $data)
	{
		$validateData = [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
			'username' => ['required', 'string', 'max:50', 'unique:users,username'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
			'phone' => ['required', 'string', 'unique:user_profiles,phone'],
			'is_influencer' => ['nullable', 'required_without_all:is_client'],
			'is_client' => ['nullable', 'required_without_all:is_influencer'],
		];

		if (basicControl()->reCaptcha_status_registration) {
			$validateData['g-recaptcha-response'] = ['required', 'captcha'];
		}

		return Validator::make($data, $validateData, [
            'name.required' => 'Full Name field is required',
            'g-recaptcha-response.required' => 'The reCAPTCHA field is required',
        ]);
	}

	protected function create(array $data)
	{
		$ref_by = null;
		if (isset($data['referral'])) {
			$ref_by = User::where('username', $data['referral'])->first();
		}
		if (!isset($ref_by)) {
			$ref_by = null;
		}

		$user = User::create([
			'name' => $data['name'],
			'ref_by' => $ref_by,
			'email' => $data['email'],
			'username' => $data['username'],
			'password' => Hash::make($data['password']),
			'language_id' => Language::select('id')->where('default_status', true)->first()->name ?? null,
			'is_influencer' => isset($data['is_influencer']) ? 1 : 0,
			'is_client' => isset($data['is_client']) ? 1 : 0,
			'email_verification' => (basicControl()->email_verification) ? 0 : 1,
			'sms_verification' => (basicControl()->sms_verification) ? 0 : 1,
		]);

		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$userProfile->phone_code = $data['phone_code'];
		$userProfile->phone = $data['phone'];
		$userProfile->save();

		return $user;
	}


	protected function registered(Request $request, $user)
	{
		$user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
		$user->save();

		$templates = NotifyTemplate::where('firebase_notify_status', 1)->where('notify_for', 0)->get()->unique('template_key');
		$value = array();
		foreach ($templates as $temp) {
			$value[] = $temp->template_key;
		}

		$user->notify_active_template = $value;
		$user->save();
	}
}
