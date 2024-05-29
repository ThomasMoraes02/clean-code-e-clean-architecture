<?php 
namespace Checkout\Application\Decorator;

use Exception;
use Throwable;
use Checkout\Application\UseCases\UseCase;
use Checkout\Application\Gateway\AuthGateway;

class AuthDecorator implements UseCase
{
    public function __construct(private readonly UseCase $useCase, private readonly AuthGateway $authGateway) {}

    public function execute(mixed $input): mixed
    {
        if(!$input->token) throw new Exception("Token is required",401);
        $payload = $this->authGateway->verify($input->token);
        return $this->useCase->execute($input);
    }
}