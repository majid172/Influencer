<?php

namespace App\Http\Controllers;

use App\Models\BasicControl;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\FirebaseNotify;
use Illuminate\Support\Facades\Artisan;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class BasicControlController extends Controller
{
	public function pusherConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.pusherConfig', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'pusher_app_id' => 'required|integer|not_in:0',
				'pusher_app_key' => 'required|string|min:1',
				'pusher_app_secret' => 'required|string|min:1',
				'pusher_app_cluster' => 'required|string|min:1',
				'push_notification' => 'nullable|integer|min:0|in:0,1',
			]);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('PUSHER_APP_ID', $purifiedData->pusher_app_id, $env);
			$env = $this->set('PUSHER_APP_KEY', $purifiedData->pusher_app_key, $env);
			$env = $this->set('PUSHER_APP_SECRET', $purifiedData->pusher_app_secret, $env);
			$env = $this->set('PUSHER_APP_CLUSTER', $purifiedData->pusher_app_cluster, $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			$basicControl->push_notification = $purifiedData->push_notification;
			$basicControl->save();

			return back()->with('success', 'Configuration Changes Successfully');
		}
	}


	public function firebaseConfig(Request $request)
	{
		$control = FirebaseNotify::firstOrNew();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.firebaseConfig', compact('control'));
		} elseif ($request->isMethod('post')) {
			$request->validate([
				'server_key' => 'required|string',
				'vapid_key' => 'required|string',
				'api_key' => 'required|string',
				'auth_domain' => 'required|string',
				'project_id' => 'required|string',
				'storage_bucket' => 'required|string',
				'messaging_sender_id' => 'required|string',
				'app_id' => 'required|string',
				'measurement_id' => 'required|string',
			]);
			$purifiedData = Purify::clean($request->all());
			$purifiedData = (object)$purifiedData;

			$control->server_key = $purifiedData->server_key;
			$control->vapid_key = $purifiedData->vapid_key;
			$control->api_key = $purifiedData->api_key;
			$control->auth_domain = $purifiedData->auth_domain;
			$control->project_id = $purifiedData->project_id;
			$control->storage_bucket = $purifiedData->storage_bucket;
			$control->messaging_sender_id = $purifiedData->messaging_sender_id;
			$control->app_id = $purifiedData->app_id;
			$control->measurement_id = $purifiedData->measurement_id;
			$control->user_foreground = $purifiedData->user_foreground;
			$control->user_background = $purifiedData->user_background;
			$control->admin_foreground = $purifiedData->admin_foreground;
			$control->admin_background = $purifiedData->admin_background;

			$this->writeGolobalFirebase($control);

			$control->save();
			return back()->with('success', 'Updated Successfully.');
		}
	}


	public function writeGolobalFirebase($control)
	{
		$apikey = '"' . $control->api_key . '"';
		$authDomain = '"' . $control->auth_domain . '"';
		$projectId = '"' . $control->project_id . '"';
		$storageBucket = '"' . $control->storage_bucket . '"';
		$messagingSenderId = '"' . $control->messaging_sender_id . '"';
		$appId = '"' . $control->app_id . '"';
		$measurementId = '"' . $control->measurement_id . '"';


		$myfile = fopen("firebase-messaging-sw.js", "w") or die("Unable to open file!");
		$txt = "
        self.onnotificationclick = (event) => {
            if(event.notification.data.FCM_MSG.data.click_action){
               event.notification.close();
               event.waitUntil(clients.matchAll({
                    type: 'window'
               }).then((clientList) => {
                  for (const client of clientList) {
                      if (client.url === '/' && 'focus' in client)
                          return client.focus();
                      }
                  if (clients.openWindow)
                      return clients.openWindow(event.notification.data.FCM_MSG.data.click_action);
                  }));
            }
        };
        importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
               importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

        const firebaseConfig = {
			apiKey: $apikey,
			authDomain: $authDomain,
			projectId: $projectId,
			storageBucket: $storageBucket,
			messagingSenderId: $messagingSenderId,
			appId: $appId,
			measurementId: $measurementId
        };

       	const app = firebase.initializeApp(firebaseConfig);
       	const messaging = firebase.messaging();

		messaging.setBackgroundMessageHandler(function (payload) {
			if (payload.notification.background && payload.notification.background == 1) {
				const title = payload.notification.title;
				const options = {
					body: payload.notification.body,
					icon: payload.notification.icon,
				};
				return self.registration.showNotification(
					title,
					options,
				);
			}
		});";
		fwrite($myfile, $txt);
		fclose($myfile);

		return 0;
	}


	public function emailConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.emailConfig', compact('basicControl'));
		} else {
			$purifiedData = Purify::clean($request->all());
			$validateFor = [
				'mail_host' => 'required|string|min:5',
				'mail_port' => 'required|integer|not_in:0',
				'mail_username' => 'required|string|min:5',
				'mail_password' => 'required|string|min:5',
				'mail_from' => 'required|string|email',
				'email_notification' => 'nullable|integer|min:0|in:0,1',
				'email_verification' => 'nullable|integer|min:0|in:0,1',
			];
			$validator = Validator::make($purifiedData, $validateFor);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;
			$basicControl->email_notification = $purifiedData->email_notification;
			$basicControl->email_verification = $purifiedData->email_verification;
			$basicControl->save();

			$envPath = base_path('.env');
			$env = file($envPath);

			$env = $this->set('MAIL_MAILER', '"smtp"', $env);
			$env = $this->set('MAIL_HOST', '"' . $purifiedData->mail_host . '"', $env);
			$env = $this->set('MAIL_PORT', '"' . $purifiedData->mail_port . '"', $env);
			$env = $this->set('MAIL_USERNAME', '"' . $purifiedData->mail_username . '"', $env);
			$env = $this->set('MAIL_PASSWORD', '"' . $purifiedData->mail_password . '"', $env);
			$env = $this->set('MAIL_FROM_ADDRESS', '"' . $purifiedData->mail_from . '"', $env);
			$env = $this->set('MAIL_ENCRYPTION', '"' . $purifiedData->mail_encryption . '"', $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);


			$emailtemplates = EmailTemplate::get();
			foreach ($emailtemplates as $emailtemplate) {
				$emailtemplate->email_from = $purifiedData->mail_from;
				$emailtemplate->save();
			}
			return back()->with('success', 'Successfully Updated');
		}
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

	public function index($settings = null)
	{
		$settings = $settings ?? 'settings';

		abort_if(!in_array($settings, array_keys(config('generalsettings'))), 404);
		$settingsDetails = config("generalsettings.{$settings}");

		return view('admin.control_panel.settings', compact('settings', 'settingsDetails'));
	}

	public function basic_control(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.basic-control', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'site_title' => 'required|min:3',
				'base_currency' => 'required',
				'currency_symbol' => 'required',
				'time_zone' => 'required',
				'fraction_number' => 'required|integer',
				'paginate' => 'required|integer',
				'daily_limit' => 'required|integer',
				'primaryColor' => 'required',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$basicControl->site_title = $purifiedData->site_title;
			$basicControl->primaryColor = $purifiedData->primaryColor;
			$basicControl->secondaryColor = $purifiedData->secondaryColor;
			$basicControl->time_zone = $purifiedData->time_zone;
			$basicControl->base_currency = $purifiedData->base_currency;
			$basicControl->currency_symbol = $purifiedData->currency_symbol;
			$basicControl->fraction_number = $purifiedData->fraction_number;
			$basicControl->paginate = $purifiedData->paginate;
			$basicControl->daily_limit = $purifiedData->daily_limit;
			$basicControl->days = $purifiedData->days;
			$basicControl->error_log = $purifiedData->error_log;
			$basicControl->strong_password = $purifiedData->strong_password;
			$basicControl->registration = $purifiedData->registration;
			$basicControl->is_active_cron_notification = $purifiedData->is_active_cron_notification;
			$basicControl->save();

			config(['basic.site_title' => $basicControl->site_title]);
			config(['basic.primaryColor' => $basicControl->primaryColor]);
			config(['basic.secondaryColor' => $basicControl->secondaryColor]);
			config(['basic.time_zone' => $basicControl->time_zone]);
			config(['basic.base_currency' => $basicControl->base_currency]);
			config(['basic.currency_symbol' => $basicControl->currency_symbol]);
			config(['basic.fraction_number' => (int)$basicControl->fraction_number]);
			config(['basic.paginate' => (int)$basicControl->paginate]);
			config(['basic.daily_limit' => (int)$basicControl->daily_limit]);
			config(['basic.days' => (int)$basicControl->days]);
			config(['basic.error_log' => (int)$basicControl->error_log]);
			config(['basic.strong_password' => (int)$basicControl->strong_password]);
			config(['basic.registration' => (int)$basicControl->registration]);
			config(['basic.is_active_cron_notification' => (int)$basicControl->is_active_cron_notification]);

			$fp = fopen(base_path() . '/config/basic.php', 'w');
			fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
			fclose($fp);

			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('APP_DEBUG', ($basicControl->error_log == 1) ? 'true' : 'false', $env);
			$env = $this->set('APP_TIMEZONE', '"' . $purifiedData->time_zone . '"', $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			session()->flash('success', ' Updated Successfully');
			Artisan::call('optimize:clear');
			return back();
		}
	}

	public function pluginConfig()
	{
		return view('admin.control_panel.pluginConfig');
	}

	public function tawkConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.tawkControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'tawk_id' => 'required|min:3',
				'tawk_status' => 'nullable|integer|min:0|in:0,1',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->tawk_id = $purifiedData->tawk_id;
			$basicControl->tawk_status = $purifiedData->tawk_status;
			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function fbMessengerConfig(Request $request)
	{
		$basicControl = basicControl();

		if ($request->isMethod('get')) {
			return view('admin.control_panel.fbMessengerControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'fb_messenger_status' => 'nullable|integer|min:0|in:0,1',
				'fb_app_id' => 'required|min:3',
				'fb_page_id' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->fb_app_id = $purifiedData->fb_app_id;
			$basicControl->fb_page_id = $purifiedData->fb_page_id;
			$basicControl->fb_messenger_status = $purifiedData->fb_messenger_status;

			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function googleRecaptchaConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.googleReCaptchaControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'reCaptcha_status_login' => 'nullable|integer|min:0|in:0,1',
				'reCaptcha_status_registration' => 'nullable|integer|min:0|in:0,1',
				'NOCAPTCHA_SECRET' => 'required|min:3',
				'NOCAPTCHA_SITEKEY' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->reCaptcha_status_login = $purifiedData->reCaptcha_status_login;
			$basicControl->reCaptcha_status_registration = $purifiedData->reCaptcha_status_registration;
			$basicControl->reCaptcha_status_admin_login = $purifiedData->reCaptcha_status_admin_login;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('NOCAPTCHA_SECRET', $purifiedData->NOCAPTCHA_SECRET, $env);
			$env = $this->set('NOCAPTCHA_SITEKEY', $purifiedData->NOCAPTCHA_SITEKEY, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function manualRecaptchaConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.manualReCaptchaControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'reCaptcha_status_registration	' => 'nullable|integer|min:0|in:0,1',
				'reCaptcha_status_registration' => 'nullable|integer|min:0|in:0,1',
				'reCaptcha_status_admin_login' => 'nullable|integer|min:0|in:0,1',

			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;
			$basicControl->reCaptcha_status_login = $purifiedData->reCaptcha_status_login;
			$basicControl->reCaptcha_status_registration	= $purifiedData->reCaptcha_status_registration;
			$basicControl->reCaptcha_status_admin_login = $purifiedData->reCaptcha_status_admin_login;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}


	public function googleAnalyticsConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.analyticControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'MEASUREMENT_ID' => 'required|min:3',
				'analytic_status' => 'nullable|integer|min:0|in:0,1',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->MEASUREMENT_ID = $purifiedData->MEASUREMENT_ID;
			$basicControl->analytic_status = $purifiedData->analytic_status;
			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}


	// Social Login
	public function sociaLoginConfig()
	{
		return view('admin.control_panel.socialLoginConfig');
	}


	public function googleLoginConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.googleLoginControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'google_status_login' => 'nullable|integer|min:0|in:0,1',
				'google_status_registration' => 'nullable|integer|min:0|in:0,1',
				'GOOGLE_CLIENT_ID' => 'required|min:3',
				'GOOGLE_CLIENT_SECRET' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->google_status_login = $purifiedData->google_status_login;
			$basicControl->google_status_registration = $purifiedData->google_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('GOOGLE_CLIENT_ID', $purifiedData->GOOGLE_CLIENT_ID, $env);
			$env = $this->set('GOOGLE_CLIENT_SECRET', $purifiedData->GOOGLE_CLIENT_SECRET, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function facebookLoginConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.facebookLoginControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'facebook_status_login' => 'nullable|integer|min:0|in:0,1',
				'facebook_status_registration' => 'nullable|integer|min:0|in:0,1',
				'FACEBOOK_CLIENT_ID' => 'required|min:3',
				'FACEBOOK_CLIENT_SECRET' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->facebook_status_login = $purifiedData->facebook_status_login;
			$basicControl->facebook_status_registration = $purifiedData->facebook_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('FACEBOOK_CLIENT_ID', $purifiedData->FACEBOOK_CLIENT_ID, $env);
			$env = $this->set('FACEBOOK_CLIENT_SECRET', $purifiedData->FACEBOOK_CLIENT_SECRET, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function githubLoginConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.githubLoginControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'github_status_login' => 'nullable|integer|min:0|in:0,1',
				'github_status_registration' => 'nullable|integer|min:0|in:0,1',
				'GITHUB_CLIENT_ID' => 'required|min:3',
				'GITHUB_CLIENT_SECRET' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->github_status_login = $purifiedData->github_status_login;
			$basicControl->github_status_registration = $purifiedData->github_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('GITHUB_CLIENT_ID', $purifiedData->GITHUB_CLIENT_ID, $env);
			$env = $this->set('GITHUB_CLIENT_SECRET', $purifiedData->GITHUB_CLIENT_SECRET, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function twitterLoginConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.twitterLoginControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'twitter_status_login' => 'nullable|integer|min:0|in:0,1',
				'twitter_status_registration' => 'nullable|integer|min:0|in:0,1',
				'TWITTER_CLIENT_ID' => 'required|min:3',
				'TWITTER_CLIENT_SECRET' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->twitter_status_login = $purifiedData->twitter_status_login;
			$basicControl->twitter_status_registration = $purifiedData->twitter_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('TWITTER_CLIENT_ID', $purifiedData->TWITTER_CLIENT_ID, $env);
			$env = $this->set('TWITTER_CLIENT_SECRET', $purifiedData->TWITTER_CLIENT_SECRET, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function linkedinLoginConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.linkedinLoginControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'linkedin_status_login' => 'nullable|integer|min:0|in:0,1',
				'linkedin_status_registration' => 'nullable|integer|min:0|in:0,1',
				'LINKEDIN_CLIENT_ID' => 'required|min:3',
				'LINKEDIN_CLIENT_SECRET' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->linkedin_status_login = $purifiedData->linkedin_status_login;
			$basicControl->linkedin_status_registration = $purifiedData->linkedin_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('LINKEDIN_CLIENT_ID', $purifiedData->LINKEDIN_CLIENT_ID, $env);
			$env = $this->set('LINKEDIN_CLIENT_SECRET', $purifiedData->LINKEDIN_CLIENT_SECRET, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);
			Artisan::call('config:clear');
			Artisan::call('cache:clear');
			return back()->with('success', 'Successfully Updated');
		}
	}

	public function captchaControl(Request $request)
	{

		if($request->status == 1)
		{
			$basic = basicControl();
			$basic->google_reCaptcha_status = 1;
			$basic->save();
		}
		else{
			$basic = basicControl();
			$basic->google_reCaptcha_status = 0;
			$basic->save();
		}

		return response()->json(['message' => 'Success']);
	}

	public function manualCaptcha(Request $request)
	{

		if($request->status == 1)
		{
			$basic = basicControl();
			$basic->manual_reCaptcha_status = 1;
			$basic->save();
		}
		else{
			$basic = basicControl();
			$basic->manual_reCaptcha_status = 0;
			$basic->save();
		}
		return response()->json(['message' => 'Success']);
	}


}
