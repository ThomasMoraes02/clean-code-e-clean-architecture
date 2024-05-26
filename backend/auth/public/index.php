<?php

require_once __DIR__ . "/bootstrap.php";

use Auth\Infra\Http\Server\SlimAdapter;
use Auth\Application\UseCases\Login\Login;
use Auth\Application\UseCases\SignUp\SignUp;
use Auth\Infra\Http\Controller\AuthController;
use Auth\Application\UseCases\VerifyToken\VerifyToken;
use Auth\Infra\Http\Middleware\ErrorMiddleware;
use Auth\Infra\Http\Middleware\OutputJsonMiddleware;
use Auth\Infra\Repository\UserRepositorySqlite;

$httpServer = new SlimAdapter();

$databasePath = __DIR__ . "/../database/database.sqlite";
$pdo = new PDO("sqlite:{$databasePath}");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)");

$userRepository = new UserRepositorySqlite($pdo);

$signUp = new SignUp($userRepository);
$login = new Login($userRepository,$expiresIn,$secretKey,$dateTime);
$verifyToken = new VerifyToken($secretKey);
$authController = new AuthController($httpServer,$signUp,$login,$verifyToken);

$httpServer->addMiddleware(new ErrorMiddleware());
$httpServer->addMiddleware(new OutputJsonMiddleware());

$httpServer->listen();