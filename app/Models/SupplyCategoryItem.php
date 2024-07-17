<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyCategoryItem extends Model
{
    use HasFactory;
    protected $table ="supply_category";

    public function parentCategory(){
        return $this->belongsTo(SupplyCategoryItem::class,'parent_category');
    }

    public function items(){
        return $this->hasMany(SupplyItems::class,'supply_category_id','id');
    }
}
