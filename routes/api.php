<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;

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
Route::post('/customer', [CustomerController::class, 'store']);

Route::put('/customer/{customer}', [CustomerController::class, 'update']);

Route::get('/payment/calculate/{value}/{amount}', [PaymentController::class, 'calculate']);

Route::post('/crypto/{token}', [CryptoController::class, 'crypto']);
