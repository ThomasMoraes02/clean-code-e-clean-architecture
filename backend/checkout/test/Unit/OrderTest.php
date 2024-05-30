<?php

use Checkout\Domain\Entities\Order;
use Checkout\Domain\Entities\Product;

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

test("Deve criar um pedido e salvar a data e horário de criação", function() {
    $order = new Order("order-1", new DateTimeImmutable(date('2024-05-29 22:35:10')));
    $order->addItem(new Product("p1", "Product 1", 100.0), 1);
    expect($order->getCreatedAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($order->getCreatedAt()->format('Y-m-d H:i:s'))->toBe('2024-05-29 22:35:10');
});