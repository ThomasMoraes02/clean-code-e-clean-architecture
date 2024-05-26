<?php 
namespace Auth\Application\UseCases\Login;

class Input
{
    public function __construct(public readonly string $email, public readonly string $password) {}
}