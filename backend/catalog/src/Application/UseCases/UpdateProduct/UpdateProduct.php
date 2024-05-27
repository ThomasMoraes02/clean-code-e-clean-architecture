<?php 
namespace Catalog\Application\UseCases\UpdateProduct;

use PHPUnit\Metadata\Exception;
use Catalog\Application\Repository\ProductRepository;
use Catalog\Application\UseCases\UpdateProduct\Input;
use Catalog\Application\UseCases\UpdateProduct\Output;
use Catalog\Domain\Entities\Product;

class UpdateProduct
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function execute(Input $input): Output
    {
        $product = $this->productRepository->getByUuid($input->uuid);
        if(!$product) throw new Exception("Product not found");
        $productUpdated = new Product(
            $product->uuid(),
            $input->name ?? $product->name(),
            $input->code ?? $product->code(),
            $input->price ?? $product->price(),
            $input->quantity ?? $product->quantity()
        );

        $this->productRepository->update($productUpdated);
        return new Output($productUpdated->uuid());
    }
}