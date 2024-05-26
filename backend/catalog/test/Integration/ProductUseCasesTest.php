<?php

use Auth\Application\UseCases\CreateProduct\Input;
use Auth\Infra\Repository\ProductRepositoryMemory;
use Auth\Application\UseCases\GetProducts\GetProducts;
use Auth\Application\UseCases\CreateProduct\CreateProduct;
use Auth\Application\UseCases\GetProducts\Input as GetProductsInput;

beforeEach(function() {
    $this->productRepository = new ProductRepositoryMemory();
});

dataset("products", [
    [
        [
            [
                "name" => "Product 1",
                "code" => "ABC-123",
                "price" => 150.0,
                "quantity" => 10
            ],
            [
                "name" => "Product 2",
                "code" => "ABC-1234",
                "price" => 20.0,
                "quantity" => 8
            ]
        ]
    ]
]);

test("Deve criar um produto", function() {
    $input = new Input("Product 1","ABC-123",150.0,10);
    $output = (new CreateProduct($this->productRepository))->execute($input);
    expect($output->uuid)->toBeString();
});

test("Deve lançar uma exceção ao tentar criar um produto com code existente", function() {
    $input = new Input("Product 1","ABC-123",150.0,10);
    $input2 = new Input("Product 2","ABC-123",20.0,8);
    $useCase = new CreateProduct($this->productRepository);

    $useCase->execute($input);
    expect(fn() => $useCase->execute($input2))->toThrow(Exception::class);
});

test("Deve listar os produtos do repositório", function(array $products) {
    $useCase = new CreateProduct($this->productRepository);
    foreach($products as $product) {
        $input = new Input($product["name"],$product["code"],$product["price"],$product["quantity"]);
        $useCase->execute($input);
    }

    $input = new GetProductsInput();
    $useCase = new GetProducts($this->productRepository);
    $output = $useCase->execute($input);
    expect($output)->toBeArray();
    expect(count($output))->toBe(2);
    expect($output[0]->name)->toBe("Product 1");
    expect($output[0]->code)->toBe("ABC-123");
    expect($output[0]->price)->toBe(150.0);
    expect($output[0]->uuid)->toBeString();
})->with("products");