<?php 
namespace Auth\Application\UseCases\Login;

class Output
{
    public function __construct(public readonly string $token) {}
}