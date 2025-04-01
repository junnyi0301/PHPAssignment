<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    /** @use HasFactory<\Database\Factories\FoodFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
    ];

    public function allowSize()
    {
        return $this->category !== "Drinks";
    }

    public function allowTemperature()
    {
        return $this->category === "Drinks";
    }

    protected $casts = [
        'price' => 'decimal:2',
    ];
}