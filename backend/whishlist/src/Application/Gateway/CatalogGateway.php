<?php 
namespace Whishlist\Application\Gateway;

use Whishlist\Domain\Entities\Product;

interface CatalogGateway
{
    public function getProduct(string $uuid): Product;

    /** @return Product[] */
    public function getProducts(): array;
}