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
     * @param object $entity
     * @param array $data
     * @return mixed
     */
    public function updateStore(object $entity, array $data)
    {
        return $entity->update($data);
    }

    /**
     * @param object $entity
     * @return mixed
     */
    public function destroyStore(object $entity)
    {
        return $entity->delete();
    }
}
