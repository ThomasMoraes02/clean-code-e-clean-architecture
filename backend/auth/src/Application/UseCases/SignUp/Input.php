<?php 
namespace Auth\Application\UseCases\SignUp;

class Input
{
    public function __construct(public readonly string $name, public readonly string $email, public readonly string $password) {}
}