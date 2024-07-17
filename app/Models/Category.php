<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }

    public function getSubCategories($categoryId)
    {
        $subCategories = Category::where('parent_category', $categoryId)->orderBy('id','desc')->get();

        return $subCategories;
    }
}
