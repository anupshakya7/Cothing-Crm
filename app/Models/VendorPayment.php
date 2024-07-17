<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    use HasFactory;

    public function Vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
