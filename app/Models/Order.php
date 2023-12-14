<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

	protected $fillable= ['id','order_no','package_name','user_id','influencer_id'];

	public function listing()
	{
		return $this->belongsTo(Listing::class,'listing_id','id');
	}

	public function getDeliveryDateAttribute($value)
	{
		return dateTime($value, 'd M Y ');
	}
	public function getSubmitDateAttribute($value)
	{
		return dateTime($value,'d M Y');
	}

	public function getCreatedAtAttribute($value)
	{
		return dateTime($value,'d M Y');
	}

	public function client()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}
	public function influencer()
	{
		return $this->belongsTo(User::class,'influencer_id','id');
	}
}
