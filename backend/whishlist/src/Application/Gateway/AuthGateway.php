<?php 
namespace Checkout\Application\Gateway;

interface AuthGateway
{
    public function verify(string $token): mixed;
}