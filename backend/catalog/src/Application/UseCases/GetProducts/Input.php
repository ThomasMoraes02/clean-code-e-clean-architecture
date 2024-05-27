<?php 
namespace Auth\Application\UseCases\GetProducts;

class Input
{
    public function __construct(
        public ?string $uuid = null,
        public ?string $code = null,
        public ?string $name = null,
    ) {}
}