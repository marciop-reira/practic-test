<?php

use App\Http\Controllers\{
    StoreController,
    ProductController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('store', StoreController::class);
Route::apiResource('product', ProductController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
