<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function subCategory(){
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

}
