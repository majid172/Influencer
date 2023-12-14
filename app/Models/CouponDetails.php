<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponDetails extends Model
{
	use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
