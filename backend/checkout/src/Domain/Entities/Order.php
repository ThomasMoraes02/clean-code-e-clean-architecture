<?php 
namespace Checkout\Domain\Entities;

use Ramsey\Uuid\Uuid;
use Checkout\Domain\Entities\Item;
use Checkout\Domain\Entities\Product;
use Exception;

class Order
{
    private readonly string $uuid;

    /** @var Item[] */
    private array $items = [];

    public function __construct(?string $uuid = null) 
    {
        if(!$uuid) $uuid = Uuid::uuid4()->toString();
        $this->uuid = $uuid;
    }

    public function addItem(Product $product, int $quantity): void
    {
        if($quantity <= 0) throw new Exception("Invalid quantity");
        if(array_key_exists($product->uuid,$this->items)) throw new Exception("Duplicated item");
        $this->items[$product->uuid] = new Item($product->uuid,$product->price,$quantity);
    }

    public function getTotal(): float
    {
        $total = 0;
        /** @var Item $item */
        foreach($this->items as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}