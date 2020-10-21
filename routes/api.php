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

Route::apiResource('/backend/users', UsersController::class)
->middleware(['auth:api', 'role:super-admin']);

Route::post('/backend/users/checkEmailUniqueness', 
  [UsersController::class, 'checkEmailUniqueness'])
  ->middleware(['auth:api', 'role:super-admin']);
