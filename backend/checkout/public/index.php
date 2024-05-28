<?php

require_once __DIR__ . "/bootstrap.php";

use Checkout\Infra\Http\Server\SlimAdapter;
use Checkout\Infra\Http\Middleware\ErrorMiddleware;
use Checkout\Infra\Http\Middleware\OutputJsonMiddleware;
use Checkout\Application\UseCases\Checkout\Checkout;
use Checkout\Infra\Gateway\CatalogGatewayHttp;
use Checkout\Infra\Http\Client\GuzzleAdapter;
use Checkout\Infra\Http\Controller\CheckoutController;
use Checkout\Infra\Repository\OrderRepositorySqlite;

$httpServer = new SlimAdapter();
$httpClient = new GuzzleAdapter("http://localhost:8008");

$databasePath = __DIR__ . "/../database/database.sqlite";
$pdo = new PDO("sqlite:{$databasePath}");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE IF NOT EXISTS orders (
    uuid VARCHAR(255) NOT NULL,
    total FLOAT NOT NULL
);");
$pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
    order_uuid VARCHAR(255) NOT NULL,
    product_uuid VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    quantity INTEGER NOT NULL
);");

$orderRepository = new OrderRepositorySqlite($pdo);

$catalogGateway = new CatalogGatewayHttp($httpClient);

$checkout = new Checkout($orderRepository,$catalogGateway);
$checkoutController = new CheckoutController($httpServer, $checkout);

$httpServer->addMiddleware(new ErrorMiddleware());
$httpServer->addMiddleware(new OutputJsonMiddleware());

$httpServer->listen();