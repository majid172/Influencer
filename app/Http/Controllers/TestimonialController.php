<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\User;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
	use Notify, Upload;
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

    public function store(Request $request)
    {

		$request->validate([
			'first_name' => 'required|string',
			'email' => 'required|email',
			'link' => 'required|string',
			'client_title' => "required",
			'project_type' => 'required',
			'message' => 'required|max:800'
		]);

		$exists = Testimonial::where('email', $request->email)->exists();
		if($exists)
		{
			return redirect()->route('user.profile')->with('error','Existing email');
		}
		if($this->user->email == $request->email)
		{
			return redirect()->route('user.profile')->with('error','Please insert valid email');
		}


		$testimonials  = new Testimonial();
		$testimonials->user_id = $this->user->id;
		$testimonials->first_name = $request->first_name;
		$testimonials->last_name = $request->last_name;
		$testimonials->email = $request->email;
		$testimonials->link = $request->link;
		$testimonials->client_title = $request->client_title;
		$testimonials->project_type = $request->project_type;
		$testimonials->message = $request->message;

		$testimonials->save();

//		send email to client...
		$client = User::where('email',$request->email)->firstOrFail();

		$msg = [
			'name' => $this->user->name,
		];
		$userAction = [
			"link" => route('user.profile'),
			"icon" => "fas fa-user text-white"
		];
		$adminAction = [
			"icon" => "fas fa-user text-white"
		];

		$this->userPushNotification($client, 'TESTIMONIAL', $msg, $userAction);

		$this->sendMailSms($client, $type = 'TESTIMONIAL', [
			'name' => $this->user->name,
			'designation' => $this->user->profile->designation,
			'message' => $request->message,
			'link' => "<a href='" . route('testimonial.accept', ['id' => $testimonials->id]) . "' class='btn-action'>Request Accept</a>",

		]);

		return redirect()->route('user.profile')->with('success','Testimonial request successfully.');
    }


}
