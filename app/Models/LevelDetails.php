<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LevelDetails extends Model
{
	use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function level(){
        return $this->belongsTo(Level::class, 'level_id');
    }

}
