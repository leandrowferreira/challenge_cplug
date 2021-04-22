<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
