<?php
namespace Checkout\Application\Repository;

use Checkout\Domain\Entities\Order;

interface OrderRepository
{
    public function save(Order $order): void;

    public function getByUuid(string $uuid): ?Order;

    public function count(): int;
}