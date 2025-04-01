<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'size',
        'temperature',
        'quantity',
        'total_price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
