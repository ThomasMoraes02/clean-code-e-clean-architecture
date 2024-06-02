<?php 

use Whishlist\Domain\Entities\Product;
use Whishlist\Application\Gateway\CatalogGateway;
use Whishlist\Application\UseCases\AddProduct\Input;
use Whishlist\Application\UseCases\AddProduct\AddProduct;
use Whishlist\Infra\Repository\WhishlistRepositoryMemory;

test("Deve adicionar um produto a lista de desejos", function() {
    $whishlistRepository = new WhishlistRepositoryMemory();
    $catalogGateway = Mockery::mock(CatalogGateway::class);
    $catalogGateway->shouldReceive("getProduct")->andReturn(new Product("PROD01","Product 1",150.5));

    $useCase = new AddProduct($whishlistRepository, $catalogGateway);
    $input = new Input("USER01", "PROD01");
    $useCase->execute($input);

    $whishlists = $whishlistRepository->list();
    expect($whishlists)->toBeArray();
});