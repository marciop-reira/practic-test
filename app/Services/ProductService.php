<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

/**
 *
 */
class ProductService
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return mixed
     */
    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProductById(int $id)
    {
        return $this->productRepository->getProductById($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createProduct(array $data)
    {
        $product = $this->productRepository->createProduct($data);

        $product->sendCreateUpdateProductNotification('created');

        return $product;
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateProduct(int $id, array $data)
    {
        $product = $this->getProductById($id);
        if ($this->productRepository->updateProduct($product, $data)) {
            $product->sendCreateUpdateProductNotification('updated');
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyProduct(int $id)
    {
        $product = $this->getProductById($id);
        return $this->productRepository->destroyProduct($product);
    }

}
