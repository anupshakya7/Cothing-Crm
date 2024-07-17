<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function Pattern()
    {
        return $this->hasOne(Pattern::class, 'id', 'pattern_id');
    }


    public function Measurement()
    {
        return $this->hasOne(Measurement::class, 'id', 'measurement_id');
    }


}
