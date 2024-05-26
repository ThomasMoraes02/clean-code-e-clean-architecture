<?php 
namespace Auth\Application\UseCases\CreateProduct;

use Exception;
use Auth\Domain\Entities\Product;
use Auth\Application\Repository\ProductRepository;

class CreateProduct
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function execute(Input $input): Output
    {
        if($this->productRepository->getByCode($input->code)) throw new Exception("Code already in use",400);
        $product = Product::create($input->name, $input->code,$input->price, $input->quantity);
        $this->productRepository->save($product);
        return new Output($product->uuid());
    }
}