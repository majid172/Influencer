<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogDetails extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['blog_id', 'language_id', 'author', 'title', 'details'];

    protected $casts = [
        'details' => 'object'
    ];

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}
