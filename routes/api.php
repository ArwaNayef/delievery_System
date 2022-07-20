<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\ForgotPasswordController;
//use app\Http\Controllers\Auth\CodeCheckController;
//use App\Http\Controllers\Auth\ResetPasswordController;



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

//Route::post('password/email',  ForgotPasswordController::class);
//Route::post('password/code/check', CodeCheckController::class);
//Route::post('password/reset', ResetPasswordController::class);

Route::post('forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);
