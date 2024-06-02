<?php 
namespace Whishlist\Application\Repository;

use Whishlist\Domain\Entities\Product;
use Whishlist\Domain\Entities\Whishlist;

interface WhishlistRepository
{
    public function save(Whishlist $whishlist): void;

    /** @return Product[] */
    public function list(): array;
}