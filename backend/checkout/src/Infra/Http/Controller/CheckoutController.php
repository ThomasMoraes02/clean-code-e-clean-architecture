<?php 
namespace Checkout\Infra\Http\Controller;

use Checkout\Application\UseCases\Checkout\Checkout;
use Checkout\Application\UseCases\Checkout\Input;
use Checkout\Infra\Http\Server\HttpServer;

class CheckoutController
{
    public function __construct(
        private readonly HttpServer $server,
        private readonly Checkout $checkout
    ) {
        $this->server->on("POST", "/checkout", function($params, $body, $args) {
            $items = json_decode(json_encode($body->items), true);
            $input = new Input($items);
            $output = $this->checkout->execute($input);
            return ["data" => $output, "statusCode" => 201];
        });
    }
}