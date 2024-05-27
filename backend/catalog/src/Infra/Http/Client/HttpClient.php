<?php 
namespace Catalog\Infra\Http\Client;

interface HttpClient
{
    public function get(string $url): mixed;

    public function post(string $url, array $body): mixed;
}