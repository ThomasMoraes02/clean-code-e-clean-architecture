<?php 
namespace Whishlist\Application\UseCases\AddProduct;

class Input
{
    public function __construct(
        public readonly string $userId,
        public readonly string $productId
    ) {}
}