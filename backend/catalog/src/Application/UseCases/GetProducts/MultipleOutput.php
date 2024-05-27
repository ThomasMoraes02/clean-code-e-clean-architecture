<?php 
namespace Catalog\Application\UseCases\GetProducts;

class MultipleOutput
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $code,
        public float $price
    ) {}
}