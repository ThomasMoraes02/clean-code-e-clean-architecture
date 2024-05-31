<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = new AMQPStreamConnection("messaging",5672,"user", "password");

$channel = $connection->channel();

$channel->queue_declare("teste_fila", false,false,false,false);

$msg = new AMQPMessage(json_encode([
    "name" => "Thomas",
    "age" => 24
]));

$channel->basic_publish($msg, '', 'teste_fila');

echo "Mensagem enviada \n";

$channel->close();
$connection->close();