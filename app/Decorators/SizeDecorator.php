<?php

namespace App\Decorators;

use App\Models\Food;

class SizeDecorator extends FoodDecorator
{
    protected Food $food;
    protected int $optionNumber = 2;
    protected $options = ["Small", "Large"];

    public function __construct(Food $product)
    {
        $this->food = $product;
    }

    public function getFood()
    {
        return $this->food;
    }

    public function getPrice(): float
    {
        return $this->food->getPrice();
    }

    public function getOptionNumber(): int
    {
        return $this->optionNumber;
    }

    public function getOptions()
    {
        return ['Small' => 0.00, 'Large' => 5.00];  // You can dynamically fetch sizes based on product data
    }

    public function getOptionPrice(string $option)
    {
        if ($option == "Large") {
            $this->price += 5.00;
        }
    }
}
