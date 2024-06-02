<?php 
namespace Whishlist\Application\UseCases;

interface UseCase
{
    public function execute(mixed $input): mixed;
}