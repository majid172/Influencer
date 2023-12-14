<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingFee extends Model
{
	use HasFactory;

	protected $fillable = ['id', 'listing_id', 'percentage'];

	public function levels()
	{
		return $this->belongsTo(Level::class,'level_id');
	}
}
