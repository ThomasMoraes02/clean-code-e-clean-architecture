<?php
namespace Checkout\Application\UseCases\GetOrder;

class Output
{
    public function __construct(
        public readonly string $uuid, 
        public readonly float $total,
        public readonly array $items,
        public readonly string $createdAt
    ) {}
}