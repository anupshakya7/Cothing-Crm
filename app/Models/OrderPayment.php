<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'is_advance',
        'payment_date',
        'payment_received_by',
    ];


    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
