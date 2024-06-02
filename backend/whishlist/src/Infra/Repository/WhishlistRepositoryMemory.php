<?php 
namespace Whishlist\Infra\Repository;

use Whishlist\Application\Repository\WhishlistRepository;
use Whishlist\Domain\Entities\Whishlist;

class WhishlistRepositoryMemory implements WhishlistRepository
{
    public function __construct(private array $whislists = []) {}

    public function save(Whishlist $whishlist): void
    {
        $this->whislists[$whishlist->getUserId()] = $whishlist;
    }

    public function list(): array
    {
        return $this->whislists;
    }
}