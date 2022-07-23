<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

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
Route::post('update_department_by_id/{department}', [DepartmentController::class, 'update']);
Route::delete('delete_department_by_id/{department}', [DepartmentController::class, 'destroy']);
// });