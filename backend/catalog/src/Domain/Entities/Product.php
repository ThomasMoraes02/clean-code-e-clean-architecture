<?php 
namespace Auth\Domain\Entities;

use Exception;
use Ramsey\Uuid\Uuid;

class Product
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $code,
        private readonly float $price,
        private readonly int $quantity
    ) {
        if($quantity < 0) throw new Exception("Quantity cannot be negative",400);
    }

    public static function create(string $name, string $code, float $price, int $quantity): Product
    {
        $uuid = Uuid::uuid4()->toString();
        return new Product($uuid,$name,$code,$price,$quantity);
    }

    public static function restore(string $uuid, string $name, string $code, float $price, int $quantity): Product
    {
        return new Product($uuid,$name,$code,$price,$quantity);
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}