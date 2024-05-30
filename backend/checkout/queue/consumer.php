<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = new AMQPStreamConnection("messaging", 5672, "user", "password");

$channel = $connection->channel();

$channel->queue_declare("teste_fila",false,true,false,false);

$channel->basic_consume("teste_fila",no_ack:true, callback: function(AMQPMessage $message) {
    echo "[x] Mensagem recebida: " . $message->getBody() . "\n";
    // Marca a mensagem como processada
    // $message->ack();
});

try {
    // Inicia o loop de consumidores infinitamente
    $channel->consume();
} catch(Throwable $e) {
    var_dump($e);
}

$channel->close();
$connection->close();