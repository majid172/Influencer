<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
	use HasFactory, Notifiable, Notify;

	protected $appends = ['mobile', 'last-seen'];

	public function getLastSeenAttribute()
	{
		if (Cache::has('user-is-online-' . $this->id)) {
			return true;
		} else {
			return false;
		}
	}

	public function getCreatedAtAttribute($value)
	{
		return $this->localDateFormat($value);
	}

	protected function localDateFormat($value)
	{
		if (isset($value)) {
			if (isset(auth()->user()->timezone)) {
				return Carbon::parse(Carbon::parse($value)->setTimezone(auth()->user()->timezone)->toDateTimeString());
			}
			return Carbon::parse($value);
		}
		return null;
	}

	public function siteNotificational()
	{
		return $this->morphOne(SiteNotification::class, 'siteNotificational', 'site_notificational_type', 'site_notificational_id');
	}

	public function getMobileAttribute()
	{
		return optional($this->profile)->phone_code . optional($this->profile)->phone;
	}

	public function profilePicture()
	{

		$fileName = optional($this->profile)->profile_picture ?? 'boy.png';
		if ($fileName == 'boy.png') {
			$arr = explode(' ', trim($this->name));
			$firstChar = (count($arr) > 1) ? mb_substr($arr[0], 0, 1) : mb_substr($arr[0], 0, 2);
			$secondChar = (count($arr) > 1) ? mb_substr($arr[1], 0, 1) : '';
			return '<div class="img-replace-txt">' . $firstChar . $secondChar . '</div>';
		} else {
			$url = getFile(optional($this->profile)->driver, $fileName);
			return '<img  src="' . $url . '" alt="..." class="img-fluid"/>';
		}
	}

	public function coverPicture()
	{
		$fileName = optional($this->profile)->cover_picture ?? 'default.png';
		if ($fileName == 'default.png') {
			$url = getFile(config('basic.default_file_driver'), $fileName);
		} else {
			$url = getFile(optional($this->profile)->driver, $fileName);
		}
		return $url;
	}

	protected $guarded = ['id'];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'notify_active_template' => 'array'
	];


	public function profile()
	{
		return $this->hasOne(UserProfile::class, 'user_id', 'id');
	}

	public function education()
	{
		return $this->hasMany(EducationInfo::class, 'user_id', 'id');
	}

	public function testimonial()
	{
		return $this->hasMany(Testimonial::class,'user_id','id');
	}

	public function employment()
	{
		return $this->hasMany(Employment::class,'user_id','id');
	}

	public function portfolio()
	{
		return $this->hasMany(Portfolio::class,'user_id','id');
	}

	public function certification()
	{
		return $this->hasMany(Certification::class, 'user_id', 'id');
	}

	public function profileInfo()
	{
		return $this->hasOne(ProfileInfo::class, 'user_id');
	}

	public function invitation()
	{
		return $this->hasMany(Invitation::class, 'to_freelancer');
	}

	public function listingOrder()
	{
		return $this->hasMany(Order::class, 'user_id');
	}

	public function reviewer()
	{
		return $this->hasOne(Review::class, 'user_id');
	}

	public function influencerRating()
	{
		return $this->hasMany(Review::class, 'influencer_id');
	}

	public function follower()
	{
		return $this->hasMany(Follow::class, 'following_id');
	}

	public function following()
	{
		return $this->hasMany(Follow::class, 'user_id');
	}


	public function sendPasswordResetNotification($token)
	{
		$this->mail($this, 'PASSWORD_RESET', $params = [
			'message' => '<a href="' . url('user/password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
		]);

		/*
		$this->mail($this, 'PASSWORD_RESET', $params = [
//			'message' => '<a href="'.url('user/password/reset',$token).'" target="_blank">Click To Reset Password</a>',
			'message' => '<a href="'.url('user/password/reset',$token).'?email='.$this->email.'" target="_blank">Click To Reset Password</a>'
		]);

//		'message' => '<a href="'.url('user/password/reset',$token).'?email='.$this->email.'" target="_blank">Click To Reset Password</a>'

		$this->notify(new ResetPasswordNotification($token));
		*/
	}


}
