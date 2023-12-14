<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

	public function chargeLimit()
	{
		return $this->hasMany(ChargeLimit::class, 'currency_id', 'id');
	}
}
