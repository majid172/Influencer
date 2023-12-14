<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

	public function receiver()
	{
		return $this->belongsTo(User::class,'to_freelancer');
	}

	public function sender()
	{
		return $this->belongsTo(User::class,'from_client');
	}

	public function job()
	{
		return $this->belongsTo(JobPost::class,'job_id');
	}


}
