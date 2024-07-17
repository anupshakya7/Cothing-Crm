<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyItems extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(SupplyCategoryItem::class,'supply_category_id','id');
    }
}
