<?php

require_once __DIR__ . "/bootstrap.php";

use Auth\Application\UseCases\CreateProduct\CreateProduct;
use Auth\Application\UseCases\DeleteProduct\DeleteProduct;
use Auth\Infra\Http\Server\SlimAdapter;
use Auth\Infra\Http\Middleware\ErrorMiddleware;
use Auth\Infra\Repository\ProductRepositorySqlite;
use Auth\Infra\Http\Middleware\OutputJsonMiddleware;
use Auth\Application\UseCases\GetProducts\GetProducts;
use Auth\Application\UseCases\UpdateProduct\UpdateProduct;
use Auth\Infra\Http\Controller\ProductController;

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

$httpServer->addMiddleware(new ErrorMiddleware());
$httpServer->addMiddleware(new OutputJsonMiddleware());

$httpServer->listen();