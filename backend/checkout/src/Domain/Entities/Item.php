<?php 
namespace Auth\Domain\Entities;

class Item
{
    public function __construct(
        public readonly string $uuid,
        public readonly float $price,
        public readonly int $quantity,
    ) {}
}