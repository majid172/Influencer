<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSave extends Model
{
    use HasFactory;

	public function jobPost()
	{
		return $this->belongsTo(JobPost::class, 'job_id');
	}

}
