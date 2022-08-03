<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\VerificationController;
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
Route::post('/auth/customer/login/', [AuthController::class, 'CustomerLogin']);
Route::post('/auth/customer/logout/', [AuthController::class, 'CustomerLogout']);
Route::post('forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);

Route::post('email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::get('show', [OrderController::class, 'ordersByClient'])->middleware('auth:sanctum');
Route::get('store', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::get('send', [OrderController::class, 'SendOrder']);

Route::get('ShowProfile', [UserController::class, 'ShowProfile'])->middleware('auth:sanctum');
Route::get('EditProfile', [UserController::class, 'EditProfile'])->middleware('auth:sanctum');
Route::get('AddAddress', [UserController::class, 'AddAddress'])->middleware('auth:sanctum');
Route::get('accept', [DriverController::class, 'accept']);
Route::get('sendAddresses', [DriverController::class, 'sendAddresses']);

