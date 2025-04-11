<?php

namespace App\Decorator;

class SizeDecorator extends FoodDecorator
{
    protected string $size;
    protected float $sizePrice;

    public function __construct(FoodInterface $product, string $size)
    {
        parent::__construct($product);
        $this->size = $size;

        $this->sizePrice = match ($size) {
            'Small' => 0,
            'Large' => 4.00,
            default => 0,
        };
    }

    public function getName(): string
    {
        return $this->food->getName() . ' (' . $this->size . ')';
    }

    public function getPrice(): float
    {
        return $this->food->getPrice() + $this->sizePrice;
    }
}