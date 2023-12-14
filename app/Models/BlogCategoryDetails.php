<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategoryDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
