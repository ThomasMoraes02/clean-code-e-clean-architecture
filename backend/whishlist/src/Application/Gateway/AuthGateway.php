<?php 
namespace Whishlist\Application\Gateway;

interface AuthGateway
{
    public function verify(string $token): mixed;
}