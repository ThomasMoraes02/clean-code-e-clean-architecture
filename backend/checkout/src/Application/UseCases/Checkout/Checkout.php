<?php 
namespace Checkout\Application\UseCases\Checkout;

use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Domain\Entities\Order;
use Checkout\Application\Repository\OrderRepository;
use Checkout\Application\Repository\ProductRepository;

class Checkout
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly OrderRepository $orderRepository,
        private readonly CatalogGateway $catalogGateway
    ) {}

    public function execute(Input $input): Output
    {
        $order = new Order();
        if($input->items) {
            foreach($input->items as $item) {
                $product = $this->catalogGateway->getProduct($item['uuid']);
                $order->addItem($product,$item['quantity']);
            }
        }

        $this->orderRepository->save($order);
        return new Output($order->getUuid(),$order->getTotal());
    }
}