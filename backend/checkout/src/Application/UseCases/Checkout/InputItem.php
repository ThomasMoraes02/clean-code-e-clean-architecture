<?php 
namespace Checkout\Application\UseCases\Checkout;

class InputItem
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly float $price,
        public readonly int $quantity
    ) {}
}