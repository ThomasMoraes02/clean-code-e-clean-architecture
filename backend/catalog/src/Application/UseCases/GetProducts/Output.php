<?php 
namespace Auth\Application\UseCases\GetProducts;

class Output
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $code,
        public float $price
    ) {}
}