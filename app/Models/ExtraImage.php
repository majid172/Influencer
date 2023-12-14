<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraImage extends Model
{
    use HasFactory;

	protected $table = "extra_images";

	protected $guarded = ['id'];

}
