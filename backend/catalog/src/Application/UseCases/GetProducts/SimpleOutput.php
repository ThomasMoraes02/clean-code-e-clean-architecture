<?php 
namespace Auth\Application\UseCases\GetProducts;

class SimpleOutput
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $code,
        public float $price,
        public int $quantity
    ) {}
}