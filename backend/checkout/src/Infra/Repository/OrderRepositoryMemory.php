<?php 
namespace Checkout\Infra\Repository;

use Checkout\Application\Repository\OrderRepository;
use Checkout\Domain\Entities\Order;

class OrderRepositoryMemory implements OrderRepository
{
    public function __construct(private array $orders = []){}

    public function save(Order $order): void
    {
        $this->orders[$order->getUuid()] = $order;
    }

    public function getByUuid(string $uuid): ?Order
    {
        return $this->orders[$uuid] ?? null;
    }

    public function count(): int
    {
        return count($this->orders);
    }
}