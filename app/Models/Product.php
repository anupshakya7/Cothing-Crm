<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category()
    {
    	return $this->belongsTo(Page::class, 'category_id');
    }
    public function orders()
    {
    	return $this->hasMany(Order::class);
	    }
}
