<?php 
namespace Whishlist\Domain\Entities;

use Whishlist\Domain\Entities\Product;

class Whishlist
{
    /** @var Product[] */
    private array $products = [];

    public function __construct(private readonly string $userId) {}

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}