<?php 
namespace Catalog\Application\UseCases\DeleteProduct;

use Catalog\Application\Repository\ProductRepository;
use Exception;

class DeleteProduct
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function execute(string $uuid): string
    {
        $product = $this->productRepository->getByUuid($uuid);
        if(!$product) throw new Exception("Product not found");
        $this->productRepository->delete($product);
        return "Product deleted";
    }
}