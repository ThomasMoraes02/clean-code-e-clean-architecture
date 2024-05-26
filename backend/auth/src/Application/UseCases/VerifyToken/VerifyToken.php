<?php 
namespace Auth\Application\UseCases\VerifyToken;

use Auth\Domain\Entities\TokenGenerator;
use stdClass;

class VerifyToken
{
    public function __construct(private readonly string $secretKey) {}

    public function execute(string $token): stdClass
    {
        $tokenGenerator = new TokenGenerator($this->secretKey);
        return $tokenGenerator->verify($token);
    }
}