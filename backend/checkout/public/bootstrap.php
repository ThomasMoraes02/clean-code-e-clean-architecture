<?php

use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";

$dotEnv = Dotenv::createImmutable(__DIR__ . "/../");
$dotEnv->load();

date_default_timezone_set($_ENV["DATETIME_TIMEZONE"]);

$authHost = $_ENV["AUTH_SERVER_HOST"];
$catalogHost = $_ENV["CATALOG_SERVER_HOST"];

$mailHost = $_ENV["MAIL_HOST"];
$mailPort = intVal($_ENV["MAIL_PORT"]);
$mailUsername = $_ENV["MAIL_USERNAME"];
$mailPassword = $_ENV["MAIL_PASSWORD"];