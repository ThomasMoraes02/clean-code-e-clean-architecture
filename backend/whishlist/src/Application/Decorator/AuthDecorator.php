<?php 
namespace Whishlist\Application\Decorator;

use Exception;
use Whishlist\Application\UseCases\UseCase;
use Whishlist\Application\Gateway\AuthGateway;

class AuthDecorator implements UseCase
{
    public function __construct(private readonly UseCase $useCase, private readonly AuthGateway $authGateway) {}

    public function execute(mixed $input): mixed
    {
        if(!$input->token) throw new Exception("Token is required",401);
        $payload = $this->authGateway->verify($input->token);
        $input->userId = $payload->userId;
        return $this->useCase->execute($input);
    }
}