<?php 
namespace Checkout\Infra\Gateway;

use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Domain\Entities\Product;

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