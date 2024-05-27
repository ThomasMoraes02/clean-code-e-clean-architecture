<?php

use Auth\Domain\Entities\Order;
use Auth\Domain\Entities\Product;

test("Deve criar um pedido vazio", function() {
    $order = new Order("order-1");
    expect($order->getTotal())->toBe(0.0);
    expect($order->getUuid())->toBeString();
});

test("Deve criar um pedido com 3 itens", function() {
    $order = new Order();
    $order->addItem(new Product("p1", "Product 1", 100.0), 1);
    $order->addItem(new Product("p2", "Product 2", 200.0), 1);
    $order->addItem(new Product("p3", "Product 3", 300.0), 2);
    expect($order->getTotal())->toBe(900.0);
});

test("Deve lançar uma exceção ao criar um pedido com itens duplicados", function() {
    $order = new Order();
    $order->addItem(new Product("p1", "Product 1", 100.0), 1);
    expect(fn() => $order->addItem(new Product("p1", "Product 1", 100.0), 1))->toThrow(Exception::class);
});

test("Deve lançar uma exceção ao criar um pedido com itens com quantidade inválida", function() {
    $order = new Order();
    expect(fn() => $order->addItem(new Product("p1", "Product 1", 100.0), -1))->toThrow(Exception::class);
});