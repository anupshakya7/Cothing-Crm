<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function productorders()
    {
        return $this->belongsToMany(Orders::class, 'order_id');
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class, 'measurement_id');
    }
}
