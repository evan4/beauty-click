<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\UsersController;
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
  Route::get('users/{user}', [UsersController::class, 'show']);
  Route::patch('users/{user}', [UsersController::class, 'update']);
  Route::delete('users/{user}', [UsersController::class, 'destroy']);



});