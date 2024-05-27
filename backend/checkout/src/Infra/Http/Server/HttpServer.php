<?php 
namespace Checkout\Infra\Http\Server;

use Psr\Http\Server\MiddlewareInterface;

interface HttpServer
{
    public function on(string $method, string $url, callable $callback): void;

    public function addMiddleware(MiddlewareInterface $middleware): self;

    public function listen(): void;
}