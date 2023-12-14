<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Traits\Notify;
use App\Models\Template;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class LoginController extends Controller
{
	use Notify;

	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers, RedirectsUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}


	public $providers = [
		'github', 'facebook', 'google', 'twitter', 'linkedin'
	];

	public function redirectToProvider($driver)
	{
		Artisan::call('optimize:clear');

		if (!$this->isProviderAllowed($driver)) {
			return $this->sendFailedResponse("{$driver} is not currently supported");
		}

		try {
			return Socialite::driver($driver)->redirect();
		} catch (Exception $e) {
			// You should show something simple fail message
			return $this->sendFailedResponse($e->getMessage());
		}
	}

	public function handleProviderCallback($driver)
	{
		try {
			$user = Socialite::driver($driver)->user();
		} catch (Exception $e) {
			return $this->sendFailedResponse($e->getMessage());
		}

		// check for email in returned user
		return empty($user->email)
			? $this->sendFailedResponse("No email id returned from {$driver} provider.")
			: $this->loginOrCreateAccount($user, $driver);
	}

	protected function sendSuccessResponse()
	{
		return redirect()->intended($this->redirectTo)->with('success', 'Login Completed Successfully');

	}

	protected function sendFailedResponse($msg = null)
	{
		return redirect()->route('social.login')
			->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
	}

	protected function loginOrCreateAccount($providerUser, $driver)
	{
		// check for already has account
		$user = User::where('email', $providerUser->getEmail())->first();

		$setOne = 1;

		if ($user) {

			$user->update([
				'provider' => $driver,
				'provider_id' => $providerUser->id,
				'access_token' => $providerUser->token,
			]);
			$user->profile()->update([
				'profile_picture' => $providerUser->avatar,
				'last_login_at' => date('Y-m-d H:i:s'),
				'last_login_ip' => request()->getClientIp(),
			]);
		} else {
			if ($providerUser->getEmail()) { //Check email exists or not. If exists create a new user
				// create a new user
				$user = User::create([
					'name' => $providerUser->getName(),
					'email' => $providerUser->getEmail(),
					'username' => $providerUser->user['family_name'],
					'provider' => $driver,
					'provider_id' => $providerUser->getId(),
					'access_token' => $providerUser->token,
					'email_verification' => $setOne,
					'sms_verification' => $setOne,
					// user can use reset password to create a password
					'password' => NULL
				]);

				$userImage = new UserProfile();
				$userImage->user_id = $user->id;
				$userImage->profile_picture = $providerUser->avatar;
				$userImage->last_login_at = date('Y-m-d H:i:s');
				$userImage->last_login_ip = request()->getClientIp();
				$userImage->save();

			} else {
				return redirect()->route('home')->with('error', 'Please try to login using another socialite services');
			}

		}

		// login the user
		Auth::login($user, true);

		return $this->sendSuccessResponse();
	}

	private function isProviderAllowed($driver)
	{
		return in_array($driver, $this->providers) && config()->has("services.{$driver}");
	}


	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\View\View
	 */
	public function showLoginForm(Request $request)
	{
		$template = Template::where('section_name', 'login')->first() ?? null;
		return view(template() . 'auth.login', compact('template'));
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request)
	{


		$this->validateLogin($request);

		if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);
			return $this->sendLockoutResponse($request);
		}

		if ($this->guard()->validate($this->credentials($request))) {
			if (Auth::attempt([$this->username() => $request->identity, 'password' => $request->password, 'status' => 1])) {

				auth()->user()->profile()->update([
					'last_login_at' => date('Y-m-d H:i:s'),
					'last_login_ip' => $request->getClientIp(),
				]);


				return $this->sendLoginResponse($request)->with('success', 'Logged In Successfully');;
			} else {
				return back()
					->withInput()
					->withErrors(['password' => 'You are banned from this application. Please contact with system Administrator'])
					->with('status', 'You are banned from this application. Please contact with system Administrator.');
			}
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}


	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		$login = request()->input('identity');
		$field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		request()->merge([$field => $login]);
		return $field;
	}

	protected function validateLogin(Request $request)
	{


		$basicControl = basicControl();

		$rules[$this->username()] = 'required';
		$rules ['password'] = 'required';

		// Recaptcha
		if ($basicControl->reCaptcha_status_login && ($basicControl->google_reCaptcha_status)) {
			$rules['g-recaptcha-response'] = 'sometimes|required|captcha';
		}

		// Manual Recaptcha
		if (($basicControl->manual_reCaptcha_status == 1) && ($basicControl->reCaptcha_status_login == 1)) {
			$rules['captcha'] = ['required',
				Rule::when((!empty($request->captcha) && strcasecmp(session()->get('captcha'), $_POST['captcha']) != 0), ['confirmed']),
			];
		}

		$message['captcha.confirmed'] = "The captcha does not match.";
		$message['g-recaptcha-response.required'] = 'The reCAPTCHA field is required.';
		$request->validate($rules, $message);


	}

	/**
	 * The user has been authenticated.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param mixed $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		$user->timezone = $request->timezone;
		$user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
		$user->save();
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard('web');
	}

	public function logout(Request $request)
	{
		$this->guard('guard')->logout();
		$request->session()->invalidate();
		return $this->loggedOut($request) ?: redirect()->route('login')->with('success', 'Successfully Logged Out');
	}
}
