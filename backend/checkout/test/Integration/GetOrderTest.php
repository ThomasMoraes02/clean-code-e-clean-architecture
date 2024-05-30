<?php 
namespace Test\Integration;

use Exception;
use Checkout\Domain\Entities\Order;
use Checkout\Domain\Entities\Product;
use Checkout\Application\UseCases\GetOrder\Input;
use Checkout\Application\UseCases\GetOrder\GetOrder;
use Checkout\Infra\Repository\OrderRepositoryMemory;

beforeEach(function() {
    $this->orderRepository = new OrderRepositoryMemory();

    $order = new Order("123");
    $order->addItem(new Product("p1", "Product 1", 100.0), 1);
    $this->orderRepository->save($order);
});

test("Deve recuperar um pedido do repositorio", function() {
    $useCase = new GetOrder($this->orderRepository);
    $output = $useCase->execute(new Input("123"));

    expect($output->uuid)->toBe("123");
    expect($output->total)->toBe(100.0);
});

test("Deve lancar uma exceção ao recuperar um pedido inexistente", function() {
    $useCase = new GetOrder($this->orderRepository);
    expect(fn() => $useCase->execute(new Input("456")))->toThrow(Exception::class);
});