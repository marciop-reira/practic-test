<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Contracts\StoreRepositoryInterface;

/**
 *
 */
class StoreRepository implements StoreRepositoryInterface
{

    /**
     * @var Store
     */
    protected $entity;

    /**
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->entity = $store;
    }


    /**
     * @return mixed
     */
    public function getAllStores()
    {
        return $this->entity->paginate();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getStoreById(int $id)
    {
        return $this->entity->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createStore(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * @param object $store
     * @param array $data
     * @return mixed
     */
    public function updateStore(object $store, array $data)
    {
        return $store->update($data);
    }

    /**
     * @param object $store
     * @return mixed
     */
    public function destroyStore(object $store)
    {
        return $store->delete();
    }
}
