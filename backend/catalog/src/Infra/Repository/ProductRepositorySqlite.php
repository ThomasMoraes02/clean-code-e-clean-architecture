<?php 
namespace Catalog\Infra\Repository;

use Catalog\Application\Repository\ProductRepository;
use Catalog\Domain\Entities\Product;
use PDO;

class ProductRepositorySqlite implements ProductRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function save(Product $product): void
    {
        $insert = "INSERT INTO products (uuid, name, code, price, quantity) VALUES (:uuid, :name, :code, :price, :quantity)";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindValue('uuid',$product->uuid());
        $stmt->bindValue('name',$product->name());
        $stmt->bindValue('code',$product->code());
        $stmt->bindValue('price',$product->price());
        $stmt->bindValue('quantity',$product->quantity());
        $stmt->execute();
    }
    

    public function getByCode(string $code): ?Product
    {
        $select = "SELECT * FROM products WHERE code = :code";
        $stmt = $this->pdo->prepare($select);
        $stmt->bindValue('code',$code);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$product) return null;
        return Product::restore(
            $product['uuid'],
            $product['name'],
            $product['code'],
            $product['price'],
            $product['quantity']
        );
    }

    public function getByUuid(string $uuid): ?Product
    {
        $select = "SELECT * FROM products WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($select);
        $stmt->bindValue('uuid',$uuid);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$product) return null;
        return Product::restore(
            $product['uuid'],
            $product['name'],
            $product['code'],
            $product['price'],
            $product['quantity']
        );
    }

    public function getProducts(array $params = []): array
    {
        $select = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($select);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($product) => Product::restore(
            $product['uuid'],
            $product['name'],
            $product['code'],
            $product['price'],
            $product['quantity']
        ), $products);
    }

    public function update(Product $product): void
    {
        $update = "UPDATE products SET name = :name, code = :code, price = :price, quantity = :quantity WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($update);
        $stmt->bindValue('uuid',$product->uuid());
        $stmt->bindValue('name',$product->name());
        $stmt->bindValue('code',$product->code());
        $stmt->bindValue('price',$product->price());
        $stmt->bindValue('quantity',$product->quantity());
        $stmt->execute();
    }

    public function delete(Product $product): void
    {
        $delete = "DELETE FROM products WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($delete);
        $stmt->bindValue('uuid',$product->uuid());
        $stmt->execute();
    }
}