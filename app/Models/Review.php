<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

	protected $fillable = ['user_id','influencer_id','ratings','comment'];

	public function reviewer()
	{
		return $this->belongsTo(User::class,'user_id');
	}
	public function influencer()
	{
		return $this->belongsTo(User::class,'influencer_id');
	}

	Public function listing()
	{
		return $this->belongsTo(Listing::class,'listing_id');
	}
	public function getCreatedAtAttribute($value)
	{
		return dateTime($value, 'd M, Y ');
	}

}
