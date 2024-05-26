<?php 

use Auth\Application\UseCases\VerifyToken\VerifyToken;

beforeEach(function() {
    $this->token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoIiwiaWF0IjoxNzE2NjkyNDAwLCJleHAiOjI3MTY2OTI0MDAsImVtYWlsIjoidGhvbWFzQGdtYWlsLmNvbSJ9.TSUtHSV1FCj3OI2FR9hRSqCSs6_FYqLOAl_VQ6LXFi8";
    $this->secretKey = "key";
});

test("Deve verificar um token", function() {
    $verify = new VerifyToken($this->secretKey);
    $payload = $verify->execute($this->token);
    expect($payload->email)->toBe('thomas@gmail.com');
});

test("Deve verificar um token inválido", function() {
    $verify = new VerifyToken($this->secretKey);
    expect(fn() => $verify->execute("token_invalido"))->toThrow(new Exception("Invalid token", 401));
});

test("Deve verificar se o secret key é invalido", function() {
    $verify = new VerifyToken("key_invalido");
    expect(fn() => $verify->execute($this->token))->toThrow(new Exception("Invalid signature", 401));
});