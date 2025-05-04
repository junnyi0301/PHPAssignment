<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DeliveryOrder extends Model
{
    protected $fillable = ['area', 'street_number', 'house_number'];
    
    protected function streetNumber(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => encrypt($value),
        );
    }

    protected function houseNumber(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => encrypt($value),
        );
    }
}