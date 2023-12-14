<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  JobPost extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo(User::class,'creator_id');
	}
	public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->with('details');
    }

	public function proposal()
	{
		return $this->hasMany(JobProposal::class,'job_id');
	}

	public function jobSave()
	{
		return $this->hasMany(JobSave::class, 'job_id');
	}

	public function hire()
	{
		return $this->hasMany(Hire::class,'job_id','id');
	}

	public function invite()
	{
		return $this->hasMany(Invitation::class,'job_id','id');
	}




}
