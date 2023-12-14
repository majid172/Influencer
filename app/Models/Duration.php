<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;

	public function proposal()
	{
		return $this->hasMany(JobProposal::class);
	}
}
