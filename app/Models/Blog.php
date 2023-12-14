<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['blog_category_id', 'image'];

    public function language()
    {
        return $this->hasMany(Language::class, 'language_id', 'id');
    }

    public function details(){
        return $this->hasOne(BlogDetails::class, 'blog_id');
    }

    public function category(){
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
}
