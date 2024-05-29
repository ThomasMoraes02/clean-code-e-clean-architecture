<?php 
namespace Checkout\Infra\Gateway;

use Exception;
use Checkout\Infra\Http\Client\HttpClient;
use Checkout\Application\Gateway\AuthGateway;

class AuthGatewayHttp implements AuthGateway
{
    public function __construct(private readonly HttpClient $client) {}

    public function verify(string $token): mixed
    {
        $response = $this->client->post("http://localhost:8007/verify", ["token" => $token]);
        $output = json_decode($response->getBody());
        if($response->getStatusCode() != 200) {
            if(isset($output->errors->message)) throw new Exception($output->errors->message, 401);
            throw new Exception("Auth Error", 401);
        }
        return $output;
    }
}