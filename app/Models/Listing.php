<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'extra_services' => 'object',
		'faqs' => 'object',
		'requirement_ques' => 'object',
		'package' => 'array'
	];

	protected  $appends = ["cardImage"];
	public function extraImages()
	{
		return $this->hasMany(ExtraImage::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function userProfile()
	{
		return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function subCategory()
	{
		return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
	}

	public function firstPackage()
	{
		if ($this->package) {
//			$arr = [];
			foreach ($this->package as $price) {
//				array_push($arr,$pack['package_price']);
				return $price['package_price'];
			}
//			return $arr;
		}
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'listing_id', 'id');
	}

	public function review()
	{
		return $this->hasMany(Review::class,'listing_id','id');
	}

	public function getCardImageAttribute()
	{
		return getFile($this->driver, $this->image);
	}

}
