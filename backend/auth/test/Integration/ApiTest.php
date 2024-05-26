<?php

use Auth\Infra\Http\Client\GuzzleAdapter;
use GuzzleHttp\Psr7\Response;

beforeEach(function() {
    $this->client = new GuzzleAdapter("http://localhost:8007");
});

test("Deve testar o fluxo de autenticação", function() {
    $input = [
        "name" => "Thomas Moraes",
        "email" => "thomas@gmail.com",
        "password" => "123456"
    ];

    $response = $this->client->post("signup", $input);
    $output = json_decode($response->getBody());
    expect("Email already in use")->toBe($output->errors->message);
});

test("Deve testar a verificação de token", function() {
    $input = ["token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoIiwiaWF0IjoxNzE2NzU0MDU0LCJleHAiOjE3MTY3NTc2NTQsImVtYWlsIjoidGhvbWFzQGdtYWlsLmNvbSJ9.e6cdqqrumpRR9HEj8kJ70iy40Xe2pXkZziO5perDPSY"];
    $response = $this->client->post("verify", $input);
    $output = json_decode($response->getBody());
    expect($response->getStatusCode())->toBe(200);
    expect($output->email)->toBe("thomas@gmail.com");
});