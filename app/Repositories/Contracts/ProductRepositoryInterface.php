<?php

namespace App\Repositories\Contracts;

/**
 *
 */
interface ProductRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllProducts();

    /**
     * @param int $id
     * @return mixed
     */
    public function getProductById(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function createProduct(array $data);

    /**
     * @param object $product
     * @param array $data
     * @return mixed
     */
    public function updateProduct(object $product, array $data);

    /**
     * @param object $product
     * @return mixed
     */
    public function destroyProduct(object $product);
}
