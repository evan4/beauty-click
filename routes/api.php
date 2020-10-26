<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\{
  BackendController, UsersController, CategoriesController
};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/backend/login', [BackendController::class, 'login']);
Route::post('/backend/checkToken', [BackendController::class, 'checkToken']);


Route::middleware(['auth:api', 'role:super-admin'])->prefix('backend')->group(function () {

  Route::post('users/checkEmailUniqueness', 
    [UsersController::class, 'checkEmailUniqueness']);

  Route::get('users', [UsersController::class, 'index']);
  Route::post('users', [UsersController::class, 'store']);
  Route::patch('users/{user}', [UsersController::class, 'update']);
  Route::delete('users/{user}', [UsersController::class, 'destroy']);

  Route::get('categories', [CategoriesController::class, 'index']);
  Route::post('categories', [CategoriesController::class, 'store']);
  Route::patch('categories/{category}', [CategoriesController::class, 'update']);
  Route::delete('categories/{category}', [CategoriesController::class, 'destroy']);



});

Route::middleware(['auth:api', 'role:продавец'])->prefix('backend')->group(function () {



});

Route::middleware(['auth:api', 'role:клиент'])->prefix('backend')->group(function () {



});
