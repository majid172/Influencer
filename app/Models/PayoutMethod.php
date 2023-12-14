<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'bank_name' => 'object',
		'banks' => 'array',
		'parameters' => 'object',
		'extra_parameters' => 'object',
		'convert_rate' => 'object',
		'currency_lists' => 'object',
		'supported_currency' => 'object',
		'automatic_input_form' => 'object',
	];
}
