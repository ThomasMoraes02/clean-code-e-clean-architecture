<?php 
namespace Checkout\Application\UseCases\Checkout;

use Exception;
use Checkout\Domain\Entities\Order;
use Checkout\Application\UseCases\UseCase;
use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Application\Repository\OrderRepository;

class Checkout implements UseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly CatalogGateway $catalogGateway,
    ) {}

    public function execute(mixed $input): Output
    {
        $order = new Order();
        if(empty($input->items)) throw new Exception("Items not found");
        foreach($input->items as $item) {
            $product = $this->catalogGateway->getProduct($item['uuid']);
            $order->addItem($product,$item['quantity']);
        }

        $this->orderRepository->save($order);
        return new Output($order->getUuid(),$order->getTotal(),$input->email);
    }
}