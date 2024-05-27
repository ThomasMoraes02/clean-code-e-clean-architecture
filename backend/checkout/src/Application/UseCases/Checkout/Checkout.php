<?php 
namespace Checkout\Application\UseCases\Checkout;

use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Domain\Entities\Order;
use Checkout\Application\Repository\OrderRepository;
use Checkout\Application\UseCases\Checkout\InputItem;
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
            /** @var InputItem $item */
            foreach($input->items as $item) {
                $product = $this->productRepository->getProduct($item->uuid);
                // $product = $this->catalogGateway->getProduct($item->uuid);
                $order->addItem($product, $item->quantity);
            }
        }

        $this->orderRepository->save($order);
        return new Output($order->getUuid(),$order->getTotal());
    }
}