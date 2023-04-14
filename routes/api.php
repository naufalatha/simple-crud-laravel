<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('categories', [CategoryController::class, 'getCategories']);
    Route::post('categories', [CategoryController::class, 'createCategory']);
    Route::put('categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('categories/{id}', [CategoryController::class, 'deleteCategory']);

    Route::get('products', [ProductController::class, 'getProducts']);
    Route::post('products', [ProductController::class, 'createProduct']);
    Route::put('products/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);
});
