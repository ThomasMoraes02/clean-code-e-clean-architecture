<?php 
namespace Checkout\Infra\Repository;

use PDO;
use Checkout\Domain\Entities\Item;
use Checkout\Domain\Entities\Order;
use Checkout\Application\Repository\OrderRepository;
use Checkout\Domain\Entities\Product;

class OrderRepositorySqlite implements OrderRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function getByUuid(string $uuid): ?Order
    {
        $order = $this->getOrder($uuid);
        if(!$order) return null;
        $items = $this->getItems($uuid);
        foreach($items as $item) {
            $order->addItem($item['product'],$item['quantity']);
        }
        return $order;
    }

    private function getOrder(string $uuid): ?Order
    {
        $select = "SELECT * FROM orders WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($select);
        $stmt->bindValue('uuid',$uuid);
        $stmt->execute();
        $row = $stmt->fetch();
        if(!$row) return null;

        return new Order($row['uuid']);
    }

    private function getItems(string $uuid): array
    {
        $select = "SELECT * FROM order_items WHERE order_uuid = :order_uuid";
        $stmt = $this->pdo->prepare($select);
        $stmt->bindValue('order_uuid',$uuid);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $orderItems = [];
        foreach($items as $item) {
            $orderItems[] = [
                "product" => new Product($item['product_uuid'],'', $item['price']),
                "quantity" => $item['quantity']
            ];
        }

        return $orderItems;
    }

    public function save(Order $order): void
    {
        $this->saveOrder($order);
        $this->saveOrderItems($order);
    }

    private function saveOrder(Order $order): void
    {
        $insert = "INSERT INTO orders (uuid, total) VALUES (:uuid, :total)";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindValue('uuid',$order->getUuid());
        $stmt->bindValue('total',$order->getTotal());
        $stmt->execute();
    }

    private function saveOrderItems(Order $order): void
    {
        $insert = "INSERT INTO order_items (order_uuid, product_uuid, price, quantity) VALUES (:order_uuid, :product_uuid, :price, :quantity)";
        $stmt = $this->pdo->prepare($insert);

        /** @var Item $item */
        foreach($order->getItems() as $item) {
            $stmt->bindValue('order_uuid',$order->getUuid());
            $stmt->bindValue('product_uuid',$item->uuid);
            $stmt->bindValue('price',$item->price);
            $stmt->bindValue('quantity',$item->quantity);
            $stmt->execute();
        }
    }

    public function count(): int
    {
        $select = "SELECT COUNT(*) FROM orders";
        $stmt = $this->pdo->prepare($select);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row[0];
    }
}