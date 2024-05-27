<?php 
namespace Auth\Application\UseCases\UpdateProduct;

use PHPUnit\Metadata\Exception;
use Auth\Application\Repository\ProductRepository;
use Auth\Application\UseCases\UpdateProduct\Input;
use Auth\Application\UseCases\UpdateProduct\Output;
use Auth\Domain\Entities\Product;

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