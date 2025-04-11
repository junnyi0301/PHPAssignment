<?php

namespace App\Decorator;

use App\Decorator\FoodInterface;

abstract class FoodDecorator implements FoodInterface
{
    protected FoodInterface $food;

    public function __construct(FoodInterface $food)
    {
        $this->food = $food;
    }
}