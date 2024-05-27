<?php 
namespace Checkout\Application\UseCases\Checkout;

use Checkout\Application\UseCases\Checkout\InputItem;

class Input
{
    public function __construct(
        /** @var InputItem[] */
        public readonly array $items
    ) {}
}