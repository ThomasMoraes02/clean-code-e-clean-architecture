<?php 
namespace Checkout\Infra\Repository;

use Checkout\Domain\Entities\Product;
use Checkout\Application\Repository\ProductRepository;

class ProductRepositoryMemory implements ProductRepository
{
    public function __construct(private array $products = []) {}

    public function save(Product $product): void
    {
        $this->products[$product->uuid] = $product;
    }

    public function getProduct(string $uuid): ?Product
    {
        return $this->products[$uuid] ?? null;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}