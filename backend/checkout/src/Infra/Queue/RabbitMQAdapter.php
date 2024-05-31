<?php 
namespace Checkout\Infra\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQAdapter implements Queue
{
    private readonly AMQPStreamConnection $connection;

    public function connect(): void
    {
        $this->connection = new AMQPStreamConnection("messaging",5672,"user","password");
    }

    public function publish(string $queueName, mixed $message): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queueName,false,true,false,false);
        $msg = new AMQPMessage(json_encode($message));
        $channel->basic_publish($msg,'',$queueName);
        $channel->close();
        $this->connection->close();
    }
}