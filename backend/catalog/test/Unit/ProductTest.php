<?php

use Auth\Domain\Entities\Product;

test("Deve criar um produto", function() {
    $product = Product::create("Product 1","ABC-123",150,1);

    expect($product->uuid())->toBeString();
    expect($product->name())->toBe("Product 1");
    expect($product->code())->toBe("ABC-123");
    expect($product->price())->toBe(150.0);
    expect($product->quantity())->toBe(1);
});