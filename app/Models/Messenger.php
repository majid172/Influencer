<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    use HasFactory;

	protected $fillable = ['message', 'job_id', 'sender_id','receiver_id','read'];

    protected $appends = ['sent_at'];

    public function getSentAtAttribute(){
        return Carbon::parse($this->created_at)->format('d M, Y H:i');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function file()
    {
        return $this->hasMany(MessengerFile::class, 'messenger_id', 'id');
    }

	public function job()
	{
		return $this->belongsTo(JobPost::class,'job_id','id');
	}


}
