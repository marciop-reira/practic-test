<?php

namespace App\Repositories\Contracts;

/**
 *
 */
interface StoreRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAllStores();

    /**
     * @param int $id
     * @return mixed
     */
    public function getStoreById(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function createStore(array $data);

    /**
     * @param object $store
     * @param array $data
     * @return mixed
     */
    public function updateStore(object $store, array $data);

    /**
     * @param object $store
     * @return mixed
     */
    public function destroyStore(object $store);
}
