<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersOrderItem extends Model
{
    use HasFactory;
    public function Category(){
        return $this->belongsTo(SupplyCategoryItem::class,'subcategory_id','id');
    }

    public function Item(){
        return $this->belongsTo(SupplyItems::class,'item_id','id');
    }
}
