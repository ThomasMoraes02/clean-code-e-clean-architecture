<?php 
namespace Checkout\Application\UseCases\Checkout;

class Output
{
    public function __construct(
        public readonly string $uuid,
        public readonly float $total,
        public readonly ?string $email = null
    ) {}
}