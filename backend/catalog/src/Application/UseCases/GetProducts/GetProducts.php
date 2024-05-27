<?php 
namespace Auth\Application\UseCases\GetProducts;

use Exception;
use Auth\Application\UseCases\GetProducts\Input;
use Auth\Application\UseCases\GetProducts\Output;
use Auth\Application\Repository\ProductRepository;

class GetProducts
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function execute(Input $input): array
    {
        if($input->uuid) {
            $product = $this->productRepository->getByUuid($input->uuid);
            if(!$product) throw new Exception("Product not found");
            return [new SimpleOutput($product->uuid(),$product->name(),$product->code(),$product->price(), $product->quantity())];
        }

        /** @var Output[] */
        $output = [];
        $products = $this->productRepository->getProducts([
            "name" => $input->name,
            "code" => $input->code,
        ]);
        
        foreach($products as $product) {
            $output[] = new MultipleOutput($product->uuid(),$product->name(),$product->code(),$product->price());
        }
        return $output;
    }
}