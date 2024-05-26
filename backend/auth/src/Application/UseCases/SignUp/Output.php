<?php 
namespace Auth\Application\UseCases\SignUp;

class Output
{
    public function __construct(public readonly string $uuid) {}
}