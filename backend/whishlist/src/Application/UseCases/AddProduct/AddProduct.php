<?php 
namespace Whishlist\Application\UseCases\AddProduct;

use Exception;
use Whishlist\Domain\Entities\Whishlist;
use Whishlist\Application\UseCases\UseCase;
use Whishlist\Application\Gateway\CatalogGateway;
use Whishlist\Application\UseCases\AddProduct\Output;
use Whishlist\Application\Repository\WhishlistRepository;

class AddProduct implements UseCase
{
    public function __construct(
        private readonly WhishlistRepository $whislistRepository,
        private readonly CatalogGateway $catalogGateway
    ) {}

    public function execute(mixed $input): mixed
    {
        $product = $this->catalogGateway->getProduct($input->productId);
        if(!$product) throw new Exception("Product not found");
        $whishlist = new Whishlist($input->userId);
        $whishlist->addProduct($product);
        $this->whislistRepository->save($whishlist);
        return new Output();
    }
}