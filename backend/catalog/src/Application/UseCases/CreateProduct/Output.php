<?php 
namespace Catalog\Application\UseCases\CreateProduct;

class Output
{
    public function __construct(public readonly string $uuid) {}
}