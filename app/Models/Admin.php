<?php

namespace App\Models;

use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
	use HasFactory, Notifiable, Notify;

	public function getMobileAttribute()
	{
		return optional($this->profile)->phone;
	}

	public function siteNotificational()
	{
		return $this->morphOne(SiteNotification::class, 'siteNotificational', 'site_notificational_type', 'site_notificational_id');
	}

	public function profile()
	{
		return $this->hasOne(AdminProfile::class, 'admin_id', 'id');
	}

	public function profilePicture()
	{
		$filePath = config('location.admin.path');
		$fileName = optional($this->profile)->profile_picture ?? 'boy.png';

		if (file_exists($filePath . $fileName)) {
			$url = asset($filePath . $fileName);
		} else {
			$hashEmail = md5(strtolower(trim($this->email)));
			$url = "https://www.gravatar.com/avatar/$hashEmail?s=200&d=mp";
		}
		return $url;
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'username',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="'.url('admin/password/reset',$token).'?email='.$this->email.'" target="_blank">Click To Reset Password</a>'
        ]);
    }

}
