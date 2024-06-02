<?php 
namespace Whishlist\Infra\Gateway;

use Whishlist\Application\Gateway\CatalogGateway;
use Whishlist\Domain\Entities\Product;

class CatalogGatewayMemory implements CatalogGateway
{
    public function __construct(private array $catalog = []) {}

    public function getProduct(string $uuid): Product
    {
        return $this->catalog[$uuid];
    }

    public function getProducts(): array
    {
        return $this->catalog;
    }
}