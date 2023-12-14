<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
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
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest:admin')->except('logout');
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\View\View
	 */
	public function showLoginForm(Request $request)
	{

		return view('admin.auth.login');
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
		if(config('app.url') != url('/')){
			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('APP_URL', url('/'), $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');
		}

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request)) {
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	private function set($key, $value, $env)
	{
		foreach ($env as $env_key => $env_value) {
			$entry = explode("=", $env_value, 2);
			if ($entry[0] == $key) {
				$env[$env_key] = $key . "=" . $value . "\n";
			} else {
				$env[$env_key] = $env_value;
			}
		}
		return $env;
	}

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::ADMIN;


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

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard('admin');
	}

    public function logout(Request $request)
    {
        $this->guard('guard')->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect()->route('admin.login');
    }

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function validateLogin(Request $request)
	{


		$validateData[$this->username()] = 'required';
		$validateData ['password'] = 'required';
		if ((basicControl()->manual_reCaptcha_status == 1) && (basicControl()->reCaptcha_status_admin_login==1)){
		$validateData['captcha'] = ['required',
			Rule::when((!empty($request->captcha) && strcasecmp(session()->get('captcha'), $_POST['captcha']) != 0), ['confirmed']),
		];
		}


		$request->validate($validateData, [
			'g-recaptcha-response.required' => 'The reCAPTCHA field is required.',
		]);

	}
}
