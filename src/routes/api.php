<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MailVerficationsController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\LoginController;
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

Route::get('/hello', function () {
    $message = 'Hello';
    return response()->json([
    'message' => $message
    ]);
    });


Route::post('/temp_register', [RegisterController::class,'temp_register']);
Route::get('/verify', [MailVerficationsController::class, 'verify']);
Route::post('/change_password', [ChangePasswordController::class, 'change']);
Route::post('/reset_password/send_mail', [ResetPasswordController::class, 'reset_mail']);
Route::get('/reset_password/url', [ResetPasswordController::class, 'display']);
Route::post('/reset_password/reset', [ResetPasswordController::class, 'reset_password']);
Route::post('/get_info', [InfoController::class, 'get_info']);
Route::post('/login', [LoginController::class, 'login']);

