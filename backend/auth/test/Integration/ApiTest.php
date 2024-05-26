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