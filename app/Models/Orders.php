<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Krishnahimself\DateConverter\DateConverter;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'english_date',


    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Trailer::class, 'handled_by');
    }

    public function measurement()
    {
        return $this->belongsTo(Measurement::class, 'measurement_id');
    }

    public function delivery()
    {
        return $this->belongsTo(DeliveryPartner::class, 'delivery_partner_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProducts::class, 'order_id');
    }

    public function orderPayment()
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function generateOrderId($id, $order_date)
    {
        $id = $id ? $id : rand(0, 3);
        $date = explode("-", $order_date);
        $yearDigits = substr($date[0], -2);
        $monthDigits = str_pad($date[1], 2, '0', STR_PAD_LEFT);
        $datedigit = $date[2];
        // Combine year and month digits with the ID and add '#tuk'
        $orderId = $id . '-TT-' . $datedigit . '-' . $monthDigits . '-' . $yearDigits;

        return $orderId;
    }
}
