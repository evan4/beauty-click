<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/catalog/{category}', [HomeController::class, 'category']);
Route::get('/catalog/{category}/{{service}}', [HomeController::class, 'service']);


Route::get('/cart/order', [CartController::class, 'order']);
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart/thanks', [CartController::class, 'thanks']);
Route::get('/cart/add', [CartController::class, 'add']);
Route::get('/cart/change', [CartController::class, 'change']);
Route::get('/cart/remove', [CartController::class, 'remove']);
Route::get('/cart/clear', [CartController::class, 'clear']);

Route::get('/features', [HomeController::class, 'features']);

Route::get('login/facebook', [CreateNewUser::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [CreateNewUser::class, 'handleFacebookCallback']);

Route::get('login/vkontakte', [CreateNewUser::class, 'redirectToVkontakte']);
Route::get('login/vkontakte/callback', [CreateNewUser::class, 'handleVkontakteCallback']);

Route::get('login/odnoklassniki', [CreateNewUser::class, 'redirectToOdnoklassniki']);
Route::get('login/odnoklassniki/callback', [CreateNewUser::class, 'handlenOklassnikiCallback']);

Route::get('login/yandex', [CreateNewUser::class, 'redirectToYandex']);
Route::get('login/yandex/callback', [CreateNewUser::class, 'handleYandexCallback']);

Route::get('login/google', [CreateNewUser::class, 'redirectToGoogle']);
Route::get('login/google/callback', [CreateNewUser::class, 'handleGoogleCallback']);
