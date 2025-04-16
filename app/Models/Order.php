<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'xml',
        'address',
        'postal_code',
        'city',
        'payment_method',
        'consumeMethod',
        'totalPrice',
    ];
}