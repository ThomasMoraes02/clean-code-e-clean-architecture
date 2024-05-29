<?php 
namespace Checkout\Application\Decorator;

use Checkout\Application\UseCases\UseCase;

class LogDecorator implements UseCase
{
    public function __construct(private readonly UseCase $useCase) {}

    public function execute(mixed $input): mixed
    {
        echo "Log: " . json_encode($input) . "\n";
        return $this->useCase->execute($input);
    }
}