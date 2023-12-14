<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

	public function sender()
	{
		return $this->belongsTo(User::class, 'sender_id', 'id');
	}

	public function receiver()
	{
		return $this->belongsTo(User::class, 'receiver_id', 'id');
	}

	public function currency()
	{
		return $this->belongsTo(Currency::class, 'currency_id', 'id');
	}

	public function transactional()
	{
		return $this->morphOne(Transaction::class, 'transactional');
	}

	public function depositable()
	{
		return $this->morphOne(Deposit::class, 'depositable');
	}
	public function getCreatedAtAttribute($value)
	{
		return dateTime($value,'Y-m-d');
	}

}
