<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProposal extends Model
{
    use HasFactory;

	public function proposer()
	{
		return $this->belongsTo(User::class,'proposer_id');
	}

	public function job(){
		return  $this->belongsTo(JobPost::class);
	}
	public function durations()
	{
		return $this->belongsTo(Duration::class, 'duration_id','id');
	}

	public function getCreatedAtAttribute($value)
	{
		return date('M d , Y',strtotime($value));
	}

}
