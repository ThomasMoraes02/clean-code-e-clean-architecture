<?php 
namespace Catalog\Infra\Repository;

use Catalog\Application\Repository\ProductRepository;
use Catalog\Domain\Entities\Product;

class ProductRepositoryMemory implements ProductRepository
{
    public function __construct(private array $products = []) {}

    public function getProducts(array $params = []): array
    {
        return $this->products;
    }

    public function getByCode(string $code): ?Product
    {
        foreach($this->products as $product) {
            if($product->code() == $code) return $product;
        }
        return null;
    }

    public function getByUuid(string $uuid): ?Product
    {
        return $this->products[$uuid] ?? null;
    }

    public function save(Product $product): void
    {
        $this->products[$product->uuid()] = $product;
    }

    public function update(Product $product): void
    {
        $this->products[$product->uuid()] = $product;
    }

    public function delete(Product $product): void
    {
        unset($this->products[$product->uuid()]);
    }
}