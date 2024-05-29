<?php 
namespace Checkout\Application\UseCases;

interface UseCase
{
    public function execute(mixed $input): mixed;
}