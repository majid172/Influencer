<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessengerFile extends Model
{
    use HasFactory;
	protected $table = "messenger_files";

	protected $guarded = ['id'];

	public function message()
	{
		return $this->belongsTo(Messenger::class, 'messenger_id', 'id');
	}
}
