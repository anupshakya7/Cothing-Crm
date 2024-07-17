<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'supply_item',
        'rate',
        'qty',
        'date',
        'remarks',
        'confirmed_by',

    ];

    public function Vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function Item()
    {
        return $this->hasOne(SupplyItems::class, 'id', 'supply_item');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'confirmed_by');
    }

    public function OrderItem(){
        return $this->hasMany(SuppliersOrderItem::class,'supply_order_id','id');
    }

    public function VendorPayment(){
        return $this->hasMany(VendorPayment::class,'vendor_id','vendor_id');
    }
}
