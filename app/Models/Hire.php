<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hire extends Model
{
    use HasFactory;

	public function job(){
		return $this->belongsTo(JobPost::class);
	}
	public function proposser()
	{
		return $this->belongsTo(User::class,'proposser_id');
	}
	public function client()
	{
		return $this->belongsTo(User::class,'client_id');
	}
	public function escrow()
	{
		return $this->hasMany(Escrow::class);
	}

	public function proposal()
	{
		return $this->belongsTo(JobProposal::class,'proposal_id');
	}

	public function getSubmitDateAttribute($value)
	{
		return dateTime($value,'M d, Y');
	}

}
