<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

/**
 *
 */
class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @var Product
     */
    protected $entity;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->entity = $product;
    }

    /**
     * @return mixed
     */
    public function getAllProducts()
    {
        return $this->entity->with('store')->paginate();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProductById(int $id)
    {
        return $this->entity->with('store')->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createProduct(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * @param object $product
     * @param array $data
     * @return mixed
     */
    public function updateProduct(object $product, array $data)
    {
        return $product->update($data);
    }

    /**
     * @param object $product
     * @return mixed
     */
    public function destroyProduct(object $product)
    {
        return $product->delete();
    }
}
