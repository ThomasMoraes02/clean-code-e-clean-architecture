<?php

use Auth\Domain\Entities\User;
use Auth\Domain\Entities\TokenGenerator;

beforeEach(function () {
    $this->user = User::create("Thomas Moraes", "thomas@gmail.com", "abc123");
    $this->key = "key";
    $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoIiwiaWF0IjoxNzE2NjkyNDAwLCJleHAiOjI3MTY2OTI0MDAsImVtYWlsIjoidGhvbWFzQGdtYWlsLmNvbSJ9.TSUtHSV1FCj3OI2FR9hRSqCSs6_FYqLOAl_VQ6LXFi8';
    $this->date = new DateTime('2024-05-26 00:00:00', new DateTimeZone('America/Sao_Paulo')); 
});

test("Deve gerar o token do usuário", function() {
    $expiresIn = 1000000000;
    $tokenGenerator = new TokenGenerator($this->key);
    $token = $tokenGenerator->generate($this->user, $expiresIn,$this->date);
    expect($token)->toBe($this->token);
});

test("Deve validar o token gerado", function() {
    $tokenGenerator = new TokenGenerator($this->key);
    $payload = $tokenGenerator->verify($this->token);
    expect($payload->iss)->toBe("auth");
    expect($payload->email)->toBe("thomas@gmail.com");
});

test("Deve retornar um erro se o token expirar", function() {
    $tokenGenerator = new TokenGenerator($this->key);
    $expiresIn = -1000000;
    $date = new DateTime('2024-05-26 00:00:01', new DateTimeZone('America/Sao_Paulo'));
    $token = $tokenGenerator->generate($this->user, $expiresIn,$date);

    expect(fn() => $tokenGenerator->verify($token))->toThrow(new Exception("Expired token", 401));
});