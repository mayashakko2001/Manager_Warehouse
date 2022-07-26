<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InventoryProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->group(function(){
Route::get('get_all_department', [DepartmentController::class, 'index']);
Route::post('add_department', [DepartmentController::class, 'store']);
Route::get('department_by_id/{department}', [DepartmentController::class, 'show']);
Route::put('update_department_by_id/{department}', [DepartmentController::class, 'update']);
Route::delete('delete_department_by_id/{department}', [DepartmentController::class, 'destroy']);

Route::get('get_all_products', [ProductController::class, 'index']);
Route::post('add_product', [ProductController::class, 'store']);
Route::get('product_by_id/{product}', [ProductController::class, 'show']);
Route::put('update_product_by_id/{product}', [ProductController::class, 'update']);
Route::delete('delete_product_by_id/{product}', [ProductController::class, 'destroy']);

Route::get('get_all_inventory_products', [InventoryProductsController::class, 'index']);
Route::post('add_inventory_products', [InventoryProductsController::class, 'store']);
Route::get('inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'show']);
Route::put('update_inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'update']);
Route::delete('delete_inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'destroy']);
// });