<?php 
namespace Checkout\Application\UseCases\Checkout;

class Input
{
    public function __construct(
        public readonly array $items,
        public readonly ?string $token = null
    ) {}
}