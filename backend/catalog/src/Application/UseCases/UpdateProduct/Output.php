<?php 
namespace Catalog\Application\UseCases\UpdateProduct;

class Output
{
    public function __construct(public readonly string $uuid) {}
}