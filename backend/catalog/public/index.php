<?php

require_once __DIR__ . "/bootstrap.php";

use Auth\Infra\Http\Server\SlimAdapter;
use Auth\Infra\Http\Middleware\ErrorMiddleware;
use Auth\Infra\Http\Middleware\OutputJsonMiddleware;

$httpServer = new SlimAdapter();

$databasePath = __DIR__ . "/../database/database.sqlite";
$pdo = new PDO("sqlite:{$databasePath}");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$httpServer->addMiddleware(new ErrorMiddleware());
$httpServer->addMiddleware(new OutputJsonMiddleware());

$httpServer->listen();