<?php 
namespace Auth\Application\UseCases\GetProducts;

use Auth\Application\UseCases\GetProducts\Input;
use Auth\Application\UseCases\GetProducts\Output;
use Auth\Application\Repository\ProductRepository;

class GetProducts
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function execute(Input $input): array
    {
        /** @var Output[] */
        $output = [];
        $products = $this->productRepository->getProducts([
            "name" => $input->name,
            "code" => $input->code,
        ]);
        
        foreach($products as $product) {
            $output[] = new Output($product->uuid(),$product->name(),$product->code(),$product->price());
        }
        return $output;
    }
}