<?php

use Checkout\Application\UseCases\Checkout\Checkout;
use Checkout\Application\UseCases\Checkout\Input;
use Checkout\Domain\Entities\Product;
use Checkout\Infra\Gateway\CatalogGatewayMemory;
use Checkout\Infra\Repository\OrderRepositoryMemory;
use Checkout\Infra\Repository\ProductRepositoryMemory;

beforeEach(function() {
    $this->orderRepository = new OrderRepositoryMemory();
    $this->productRepository = new ProductRepositoryMemory();

    $catalog = [];
    $products = [
        [
            "uuid" => "p1",
            "name" => "Product 1",
            "price" => 100.0
        ],
        [
            "uuid" => "p2",
            "name" => "Product 2",
            "price" => 200.0
        ],
        [
            "uuid" => "p3",
            "name" => "Product 3",
            "price" => 300.0
        ]
    ];
    foreach($products as $productCatalog) {
        $product = new Product($productCatalog["uuid"],$productCatalog["name"],$productCatalog["price"]);
        $catalog[$product->uuid] = $product;
    }
    $this->catalogGateway = new CatalogGatewayMemory($catalog);

    $this->checkout = new Checkout(
        $this->productRepository,
        $this->orderRepository,
        $this->catalogGateway
    );
});

test("Deve criar um pedido com 3 produtos", function() {
    $input = new Input([
        [
            "uuid" => "p1", 
            "quantity" => 1
        ],
        [
            "uuid" => "p2", 
            "quantity" => 1
        ],
        [
            "uuid" => "p3", 
            "quantity" => 3
        ],
    ]);

    $output = $this->checkout->execute($input);
    expect($output->total)->toBe(1200.0);
});

test("Deve lancar uma exceção ao criar um pedido com itens duplicados", function() {
    $input = new Input([
        [
            "uuid" => "p1", 
            "quantity" => 1
        ],
        [
            "uuid" => "p1", 
            "quantity" => 2
        ]
    ]);

    expect(fn() => $this->checkout->execute($input))->toThrow(Exception::class);
});

test("Deve lançar uma exceção ao criar pedido com quantidade negativa", function() {
    $input = new Input([
        [
            "uuid" => "p1", 
            "quantity" => -1
        ]
    ]);

    expect(fn() => $this->checkout->execute($input))->toThrow(Exception::class);
});