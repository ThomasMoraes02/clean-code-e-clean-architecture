<?php 
namespace Catalog\Infra\Queue;

interface Queue
{
    public function connect(): void;

    public function on(string $queueName, callable $callback): void;

    public function publish(string $queueName, mixed $message): void;
}