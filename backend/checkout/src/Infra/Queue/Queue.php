<?php 
namespace Checkout\Infra\Queue;

interface Queue
{
    public function connect(): void;

    public function publish(string $queueName, mixed $message): void;
}