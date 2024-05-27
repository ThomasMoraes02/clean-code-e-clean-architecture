<?php

use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";

$dotEnv = Dotenv::createImmutable(__DIR__ . "/../");
$dotEnv->load();

$dateTime = new DateTimeImmutable('now',new DateTimeZone($_ENV["DATETIME_TIMEZONE"]));