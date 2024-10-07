<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\import_productsController;
use App\Http\Controllers\ImportsController;
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
Route::get('edit_department_by_id/{department}', [DepartmentController::class, 'edit']);
Route::get('department_by_id/{department}', [DepartmentController::class, 'show']);
Route::put('update_department_by_id/{department}', [DepartmentController::class, 'update']);
Route::delete('delete_department_by_id/{department}', [DepartmentController::class, 'destroy']);

Route::get('get_all_products', [ProductController::class, 'index']);
Route::get('edit_product_by_id/{product}', [ProductController::class, 'edit']);
Route::post('add_product', [ProductController::class, 'store']);
Route::get('product_by_id/{product}', [ProductController::class, 'show']);
Route::put('update_product_by_id/{product}', [ProductController::class, 'update']);
Route::delete('delete_product_by_id/{product}', [ProductController::class, 'destroy']);

Route::get('get_all_inventory_products', [InventoryProductsController::class, 'index']);
Route::post('add_inventory_products', [InventoryProductsController::class, 'store']);
Route::get('inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'show']);
Route::get('edit_inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'edit']);
Route::put('update_inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'update']);
Route::delete('delete_inventory_products_by_id/{inventory_products}', [InventoryProductsController::class, 'destroy']);

Route::get('get_all_dealers', [DealerController::class, 'index']);
Route::post('add_dealer', [DealerController::class, 'store']);
Route::get('dealer_by_id/{dealer}', [DealerController::class, 'show']);
Route::get('edit_dealr_by_id/{dealer}', [DealerController::class, 'edit']);
Route::put('update_dealer_by_id/{dealer}', [DealerController::class, 'update']);
Route::delete('delete_dealer_by_id/{dealer}', [DealerController::class, 'destroy']);

Route::get('get_all_imports', [ImportsController::class, 'index']);
Route::post('add_import', [ImportsController::class, 'store']);
Route::get('import_by_id/{import}', [ImportsController::class, 'show']);
Route::get('edit_import_by_id/{import}', [ImportsController::class, 'edit']);
Route::put('update_import_by_id/{import}', [ImportsController::class, 'update']);
Route::delete('delete_import_by_id/{import}', [ImportsController::class, 'destroy']);

Route::get('get_all_import_products', [import_productsController::class, 'index']);
Route::post('add_import_product', [import_productsController::class, 'store']);
Route::get('get_products_by_import_id/{import_id}', [import_productsController::class, 'show']);
Route::get('edit_import_products/{import_product_id}', [import_productsController::class, 'edit']);
Route::put('update_import_products/{import_product_id}', [import_productsController::class, 'update']);
Route::delete('delete_import_products/{import_product_id}', [import_productsController::class, 'destroy']);
// });