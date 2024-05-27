<?php 
namespace Auth\Application\UseCases\UpdateProduct;

class Input
{
    public function __construct(
        public readonly string $uuid,
        public ?string $name = null,
        public ?string $code = null,
        public ?float $price = null,
        public ?int $quantity = null,
    ) {}
}