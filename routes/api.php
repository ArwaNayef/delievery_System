<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;




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

Route::post('/auth/register/', [AuthController::class, 'register']);
Route::post('/auth/login/', [AuthController::class, 'login']);
Route::post('/auth/logout/', [AuthController::class, 'logout']);
Route::post('forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);

Route::post('email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');
