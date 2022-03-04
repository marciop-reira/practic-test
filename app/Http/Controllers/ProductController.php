<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

/**
 *
 */
class ProductController extends Controller
{

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return ProductResource::collection($products);
    }

    /**
     * @param StoreProductRequest $request
     * @return ProductResource
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());
        return new ProductResource($product);
    }

    /**
     * @param int $id
     * @return ProductResource
     */
    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);
        return new ProductResource($product);
    }

    /**
     * @param UpdateProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $this->productService->updateProduct($id, $request->validated());
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
        $this->productService->destroyProduct($id);
        return response()->json([
            'message' => 'Recurso deletado.'
        ]);
    }
}
