<?php

namespace App\Decorators;

use App\Models\Food;
use PHPUnit\Framework\Attributes\Test;

class FoodDecorator extends Food
{
    protected Food $food;

    public function __construct(Food $food)
    {
        $this->food = $food;
    }

    public function getName()
    {
        return $this->food->name;
    }

    public function getImage()
    {
        return $this->food->image;
    }

    public function getDescription()
    {
        return $this->food->description;
    }

    public function getPrice()
    {
        return $this->food->price;
    }

    public function getCategory()
    {
        return $this->food->category;
    }

    public function getId()
    {
        return $this->food->id;
    }

    public function getFood()
    {
        return $this->food;
    }
}