<?php 
namespace Auth\Application\UseCases\CreateProduct;

class Input
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
        public readonly float $price,
        public readonly int $quantity,
    ) {}
}