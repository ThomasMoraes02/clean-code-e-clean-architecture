<?php
namespace Auth\Domain\Entities;

class Product
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly float $price
    ) {}
}