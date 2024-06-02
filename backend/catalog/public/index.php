<?php

require_once __DIR__ . "/bootstrap.php";

use Catalog\Application\UseCases\CreateProduct\CreateProduct;
use Catalog\Application\UseCases\DeleteProduct\DeleteProduct;
use Catalog\Infra\Http\Server\SlimAdapter;
use Catalog\Infra\Http\Middleware\ErrorMiddleware;
use Catalog\Infra\Repository\ProductRepositorySqlite;
use Catalog\Infra\Http\Middleware\OutputJsonMiddleware;
use Catalog\Application\UseCases\GetProducts\GetProducts;
use Catalog\Application\UseCases\UpdateProduct\UpdateProduct;
use Catalog\Infra\Http\Controller\ProductController;

function main() {
    $httpServer = new SlimAdapter();

    $databasePath = __DIR__ . "/../database/database.sqlite";
    $pdo = new PDO("sqlite:{$databasePath}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        uuid VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        code VARCHAR(255) NOT NULL,
        price FLOAT NOT NULL,
        quantity INTEGER NOT NULL
    )");

    $productRepository = new ProductRepositorySqlite($pdo);

    $getProducts = new GetProducts($productRepository);
    $createProducts = new CreateProduct($productRepository);
    $updateProduct = new UpdateProduct($productRepository);
    $deleteProduct = new DeleteProduct($productRepository);

    $productController = new ProductController($httpServer, $getProducts, $createProducts, $updateProduct, $deleteProduct);
    $productController->dispatch();

    $httpServer->addMiddleware(new ErrorMiddleware());
    $httpServer->addMiddleware(new OutputJsonMiddleware());

    $httpServer->listen();
}

main();