<?php 
namespace Checkout\Infra\Gateway;

use Checkout\Application\Gateway\CatalogGateway;
use Checkout\Domain\Entities\Product;
use Checkout\Infra\Http\Client\HttpClient;
use Exception;

class CatalogGatewayHttp implements CatalogGateway
{
    public function __construct(private readonly HttpClient $client, private readonly string $host) {}

    public function getProduct(string $uuid): Product
    {
        $response = $this->client->get("{$this->host}/products/{$uuid}");
        $data = json_decode($response->getBody());
        if(is_array($data)) $data = $data[0];
        if(isset($data->errors) && isset($data->errors->message)) throw new Exception($data->errors->message);
        return new Product($data->uuid, $data->name, $data->price);
    }

    public function getProducts(): array
    {
        $response = $this->client->get("{$this->host}/products");
        $products = [];
        $data = json_decode($response->getBody());
        foreach($data as $product) {
            $products[] = new Product($product->uuid, $product->name, $product->price);
        }
        return $products;
    }
}