<?php

namespace App\Decorator;

namespace App\Models;

abstract class FoodDecorator extends Food
{
    protected $food;

    public function __construct(Food $food)
    {
        $this->food = $food;
    }

    public function getName()
    {
        return $this->food->name;
    }

    public function getPrice()
    {
        return $this->food->price;
    }

    public function getDescription()
    {
        return $this->food->description;
    }
}

class SizeDecorator extends FoodDecorator
{
    private $size;
    private $price;

    public function __construct(Food $food, $size)
    {
        parent::__construct($food);

        if (!$food->allowSize()) {
            $this->size = $size;
        } else {
            $this->size = $food->size;
            $this->price = $food->price + 5.00;
        }
    }
}

class TemperatureDecorator extends FoodDecorator
{
    private $temperature;

    public function __construct(Food $food, $temperature)
    {
        parent::__construct($food);
        if (!$food->allowTemperature()) {
            $this->temperature = $temperature;
        }
    }
}