<?php 
namespace Catalog\Application\Repository;

use Catalog\Domain\Entities\Product;

interface ProductRepository
{
    public function save(Product $product): void;

    public function getByCode(string $code): ?Product;

    public function getByUuid(string $uuid): ?Product;

    public function update(Product $product): void;

    public function delete(Product $product): void;

    /** @return Product[] */
    public function getProducts(array $params = []): array;
}