<?php

use App\Http\Controllers\{
    StoreController,
    ProductController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('store', StoreController::class);
Route::apiResource('product', ProductController::class);

Route::fallback(function (){
    return response()->json(['message' => 'Not found'], 404);
});
