<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
	protected $guarded = ['id'];

	public function chatable()
	{
		return $this->morphTo();
	}

	protected $appends = ['formatted_date'];

	public function getFormattedDateAttribute(){
		return $this->created_at->format('M d, Y h:i A');
	}
}
