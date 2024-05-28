<?php 
namespace Checkout\Infra\Gateway;

use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Domain\Entities\Product;
use Checkout\Infra\Http\Client\HttpClient;

class CatalogGatewayHttp implements CatalogGateway
{
    public function __construct(private readonly HttpClient $client) {}

    public function getProduct(string $uuid): Product
    {
        $response = $this->client->get("http://localhost:8008/products/{$uuid}");
        $data = json_decode($response->getBody());
        return new Product($data->uuid, $data->name, $data->price);
    }

    public function getProducts(): array
    {
        $response = $this->client->get("http://localhost:8008/products");
        $products = [];
        $data = json_decode($response->getBody());
        foreach($data as $product) {
            $products[] = new Product($product->uuid, $product->name, $product->price);
        }
        return $products;
    }
}