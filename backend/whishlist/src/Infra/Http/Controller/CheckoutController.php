<?php 
namespace Checkout\Infra\Http\Controller;

use Checkout\Application\UseCases\Checkout\Input;
use Checkout\Application\UseCases\GetOrder\Input as GetOrderInput;
use Checkout\Application\UseCases\UseCase;
use Checkout\Infra\Http\Server\HttpServer;

class CheckoutController
{
    public function __construct(
        private readonly HttpServer $server,
        private readonly UseCase $checkout,
        private readonly UseCase $getOrder
    ) {
        $this->server->on("POST", "/checkout", function($params, $body, $args) {
            $items = json_decode(json_encode($body->items), true);
            $input = new Input($items,$body->token);
            $output = $this->checkout->execute($input);
            return ["data" => [
                "uuid" => $output->uuid,
                "total" => $output->total
            ], "statusCode" => 201];
        });

        $this->server->on("GET", "/orders/{uuid}", function($params, $body, $args) {
            $input = new GetOrderInput($args['uuid']);
            $output = $this->getOrder->execute($input);
            return ["data" => $output, "statusCode" => 200];
        });
    }
}