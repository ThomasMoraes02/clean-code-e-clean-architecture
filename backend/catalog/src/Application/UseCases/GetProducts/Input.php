<?php 
namespace Auth\Application\UseCases\GetProducts;

class Input
{
    public function __construct(
        public ?string $code = null,
        public ?string $name = null,
    ) {}
}