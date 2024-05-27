<?php

use Catalog\Application\Repository\ProductRepository;
use Catalog\Application\UseCases\CreateProduct\Input;
use Catalog\Infra\Repository\ProductRepositoryMemory;
use Catalog\Application\UseCases\GetProducts\GetProducts;
use Catalog\Application\UseCases\CreateProduct\CreateProduct;
use Catalog\Application\UseCases\DeleteProduct\DeleteProduct;
use Catalog\Application\UseCases\GetProducts\Input as GetProductsInput;
use Catalog\Application\UseCases\UpdateProduct\Input as UpdateProductInput;
use Catalog\Application\UseCases\UpdateProduct\UpdateProduct;

beforeEach(function() {
    $this->productRepository = new ProductRepositoryMemory();
    $this->createProductUseCase = new CreateProduct($this->productRepository);
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

    $this->createProductUseCase->execute($input);
    expect(fn() => $this->createProductUseCase->execute($input2))->toThrow(Exception::class);
});

test("Deve listar os produtos do repositório", function(array $products) {
    foreach($products as $product) {
        $input = new Input($product["name"],$product["code"],$product["price"],$product["quantity"]);
        $this->createProductUseCase->execute($input);
    }

    $input = new GetProductsInput();
    $useCase = new GetProducts($this->productRepository);
    $output = $useCase->execute($input);
    expect($output)->toBeArray();
    expect(count($output))->toBe(2);
    expect($output[0])->toMatchObject([
        "name" => "Product 1",
        "code" => "ABC-123",
        "price" => 150.0
    ]);
    expect($output[0]->uuid)->toBeString();
})->with("products");

test("Deve deletar um produto do repositório", function(array $products) {
    foreach($products as $product) {
        $input = new Input($product["name"],$product["code"],$product["price"],$product["quantity"]);
        $output = $this->createProductUseCase->execute($input);
    }

    $useCase = new DeleteProduct($this->productRepository);
    $outputDeletedProduct = $useCase->execute($output->uuid);
    expect($outputDeletedProduct)->toBe("Product deleted");
    expect($this->productRepository->getByUuid($output->uuid))->toBeNull();
    expect(count($this->productRepository->getProducts()))->toBe(1);
})->with("products");

test("Deve atualizar um produto do repositório", function(array $products) {
    $output = $this->createProductUseCase->execute(new Input($products[0]["name"],$products[0]["code"],$products[0]["price"],$products[0]["quantity"]));

    $useCase = new UpdateProduct($this->productRepository);
    $input = new UpdateProductInput($output->uuid,"Product Test","ABC-123", 300.0);
    $output = $useCase->execute($input);

    $product = $this->productRepository->getByUuid($output->uuid);
    expect($product->uuid())->toBe($output->uuid);
    expect($product->name())->toBe("Product Test");
    expect($product->code())->toBe("ABC-123");
    expect($product->price())->toBe(300.0);
    expect($product->quantity())->toBe(10);
})->with("products");