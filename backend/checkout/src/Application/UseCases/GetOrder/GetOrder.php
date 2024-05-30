<?php 
namespace Checkout\Application\UseCases\GetOrder;

use Exception;
use Checkout\Application\UseCases\UseCase;
use Checkout\Application\Repository\OrderRepository;
use Checkout\Domain\Entities\Item;

class GetOrder implements UseCase
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {}

    public function execute(mixed $input): mixed
    {
        $order = $this->orderRepository->getByUuid($input->uuid);
        if(!$order) throw new Exception("Order not found");
        $items = [];
        /** @var Item $item */
        foreach($order->getItems() as $item) {
            $items[] = [
                "uuid" => $item->uuid,
                "price" => $item->price,
                "quantity" => $item->quantity
            ];
        }
        return new Output($order->getUuid(),$order->getTotal(),$items);
    }
}