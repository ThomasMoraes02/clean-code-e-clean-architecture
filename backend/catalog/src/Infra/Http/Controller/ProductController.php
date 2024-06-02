<?php 
namespace Catalog\Infra\Http\Controller;

use Catalog\Application\UseCases\CreateProduct\CreateProduct;
use Catalog\Application\UseCases\CreateProduct\Input as CreateProductInput;
use Catalog\Application\UseCases\DeleteProduct\DeleteProduct;
use Catalog\Application\UseCases\GetProducts\GetProducts;
use Catalog\Application\UseCases\GetProducts\Input as GetProductsInput;
use Catalog\Application\UseCases\UpdateProduct\Input as UpdateProductInput;
use Catalog\Application\UseCases\UpdateProduct\UpdateProduct;
use Catalog\Infra\Http\Server\HttpServer;

class ProductController
{
    public function __construct(
        private readonly HttpServer $server,
        private readonly GetProducts $getProducts,
        private readonly CreateProduct $createProduct,
        private readonly UpdateProduct $updateProduct,
        private readonly DeleteProduct $deleteProduct
    ) {}

    public function dispatch(): void
    {
        $this->server->on("GET", "/products[/{uuid}]", function($params, $body, $args) {
            $input = new GetProductsInput($args['uuid'] ?? null,$params['code'] ?? null, $params['name'] ?? null);
            $output = $this->getProducts->execute($input);
            return ["data" => $output, "statusCode" => 200];
        });

        $this->server->on("POST", "/products", function($params, $body, $args) {
            $input = new CreateProductInput($body->name, $body->code, $body->price, $body->quantity);
            $output = $this->createProduct->execute($input);
            return ["data" => $output, "statusCode" => 201];
        });

        $this->server->on("PUT", "/products/{uuid}", function($params, $body, $args) {
            $input = new UpdateProductInput(
                $args['uuid'], 
                $body->name ?? null,
                $body->code ?? null,
                $body->price ?? null,
                $body->quantity ?? null
            );
            $output = $this->updateProduct->execute($input);
            return ["data" => $output, "statusCode" => 201];
        });

        $this->server->on("DELETE", "/products/{uuid}", function($params, $body, $args) {
            $output = $this->deleteProduct->execute($args['uuid']);
            return ["data" => $output, "statusCode" => 204];
        });
    }
}