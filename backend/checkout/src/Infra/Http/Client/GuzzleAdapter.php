<?php 
namespace Auth\Infra\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class GuzzleAdapter implements HttpClient
{
    private Client $client;

    public function __construct(private readonly string $baseUri) 
    {
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    public function get(string $url): mixed
    {
        return $this->client->sendAsync($this->request('GET', $url))->wait();
    }

    public function post(string $url, array $body): mixed
    {
        try {
            return $this->sendAsync($url, $body);
        } catch(ClientException $e) {
            return $e->getResponse();
        }
    }

    private function sendAsync(string $url, array $body): mixed
    {
        $promise = $this->client->sendAsync($this->request('POST',$url,$body))->then(function (ResponseInterface $response) {
            return $response;
        });

        return $promise->wait();
    }

    private function request(string $method, string $url, array $body = []): Request
    {
        return new Request($method, $url,$this->headers(), json_encode($body));
    }

    private function headers(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'Auth',  
        ];
    }
}