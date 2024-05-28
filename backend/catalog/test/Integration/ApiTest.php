<?php 
namespace Test\Integration;

use Catalog\Infra\Http\Client\GuzzleAdapter;

test("Deve listar os produtos", function() {
    $client = new GuzzleAdapter("http://localhost:8008");
    $response = $client->get("products");
    $output = json_decode($response->getBody());
    expect($response->getStatusCode())->toBe(200);
});