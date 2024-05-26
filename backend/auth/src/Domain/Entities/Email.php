<?php 
namespace Auth\Domain\Entities;

use Exception;

class Email
{
    public function __construct(private readonly string $email) 
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email is not valid");
    }

    public function __toString(): string
    {
        return $this->email;
    }
}