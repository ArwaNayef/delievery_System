<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Customer\UserController;
use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\ResetPassword\CodeCheckController;
use App\Http\Controllers\Api\ResetPassword\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPassword\ResetPasswordController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/customer/register/', [AuthController::class, 'CustomerRegister']);
Route::post('/auth/driver/login/', [AuthController::class, 'DriverLogin']);
Route::post('/auth/driver/register/', [AuthController::class, 'DriverRegister']);

Route::post('/auth/customer/login/', [AuthController::class, 'CustomerLogin']);
Route::post('/auth/customer/logout/', [AuthController::class, 'CustomerLogout']);


Route::get('showOrders', [OrderController::class, 'ordersByClient'])->middleware('auth:sanctum');
Route::get('storeOrder', [OrderController::class, 'store'])->middleware('auth:sanctum');


Route::get('ShowProfile', [UserController::class, 'ShowProfile'])->middleware('auth:sanctum');
Route::get('EditProfile', [UserController::class, 'EditProfile'])->middleware('auth:sanctum');
Route::get('AddAddress', [UserController::class, 'AddAddress'])->middleware('auth:sanctum');


Route::get('accept', [DriverController::class, 'accept']);
Route::get('sendAddresses', [DriverController::class, 'sendAddresses']);


Route::post('password/email',  ForgotPasswordController::class)->middleware('auth:sanctum');
Route::post('password/code/check', CodeCheckController::class)->middleware('auth:sanctum');
Route::post('password/reset', ResetPasswordController::class)->middleware('auth:sanctum');
