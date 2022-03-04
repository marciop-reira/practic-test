<?php

namespace App\Services;

use App\Repositories\Contracts\StoreRepositoryInterface;

/**
 *
 */
class StoreService
{

    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @return mixed
     */
    public function getAllStores()
    {
        return $this->storeRepository->getAllStores();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getStoreById(int $id)
    {
        return $this->storeRepository->getStoreById($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createStore(array $data)
    {
        return $this->storeRepository->createStore($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStore(int $id, array $data)
    {
        $store = $this->getStoreById($id);
        return $this->storeRepository->updateStore($store, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyStore(int $id)
    {
        $store = $this->getStoreById($id);
        return $this->storeRepository->destroyStore($store);
    }

}
