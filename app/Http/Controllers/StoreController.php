<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\StoreService;

/**
 *
 */
class StoreController extends Controller
{

    /**
     * @var StoreService
     */
    private $storeService;

    /**
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $stores = $this->storeService->getAllStores();
        return StoreResource::collection($stores);
    }

    /**
     * @param StoreStoreRequest $request
     * @return StoreResource
     */
    public function store(StoreStoreRequest $request)
    {
        $store = $this->storeService->createStore($request->validated());
        return new StoreResource($store);
    }

    /**
     * @param int $id
     * @return StoreResource
     */
    public function show(int $id)
    {
        $store = $this->storeService->getStoreById($id);
        return new StoreResource($store);
    }

    /**
     * @param UpdateStoreRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, int $id)
    {
        $this->storeService->updateStore($id, $request->validated());
        return response()->json([
            'message' => 'Recurso atualizado.'
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->storeService->destroyStore($id);
        return response()->json([
            'message' => 'Recurso deletado.'
        ]);
    }
}
