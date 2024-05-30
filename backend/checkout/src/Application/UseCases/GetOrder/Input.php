<?php 
namespace Checkout\Application\UseCases\GetOrder;

class Input
{
    public function __construct(public readonly string $uuid) {}
}