<?php 
namespace Checkout\Application\Gateway;

use Checkout\Domain\Entities\Product;

interface CatalogGateway
{
    public function getProduct(string $uuid): Product;

    /** @return Product[] */
    public function getProducts(): array;
}