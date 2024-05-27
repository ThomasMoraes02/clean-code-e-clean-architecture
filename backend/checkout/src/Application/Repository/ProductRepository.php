<?php 
namespace Checkout\Application\Repository;

use Checkout\Domain\Entities\Product;

interface ProductRepository
{
    public function getProduct(string $uuid): ?Product;
    
    /** @return Product[] */
    public function getProducts(): array;
}