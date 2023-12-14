<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Escrow extends Model
{
	use HasFactory;


	public function hire()
	{
		return $this->belongsTo(Hire::class, 'hire_id');
	}

	public function getPaymentDateAttribute($value)
	{
		return dateTime($value, 'd M Y ');
	}

	public function getCreatedAtAttribute($value)
	{
		return dateTime($value,'d M Y');
	}
}
