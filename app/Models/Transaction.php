<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;

	public function transactional()
	{
		return $this->morphTo();
	}

	public function getTimeZone()
	{
		if (isset($this->created_at)) {
			if (isset(auth()->user()->timezone)) {
				return dateTime(Carbon::parse(Carbon::parse($this->created_at)->setTimezone(auth()->user()->timezone)->toDateTimeString()),'d M Y H:i');
			}
			return dateTime(Carbon::parse($this->created_at),'d M Y') ;
		}
		return null;
	}
}
