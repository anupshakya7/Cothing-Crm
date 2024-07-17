<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'contact_number', 'address', 'status',
    ];
    
    public function SupplyOrder(){
        return $this->hasOne(SuppliersOrder::class,'vendor_id');
    }

    public function SupplyOrders(){
        return $this->hasMany(SuppliersOrder::class,'vendor_id');
    }
}
