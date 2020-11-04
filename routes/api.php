<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::POST('/login', [ApiController::class, 'login']);
Route::POST('/registeration', [ApiController::class, 'registeration']);
Route::POST('/email_verify_code', [ApiController::class, 'email_verify_code']);
Route::POST('/email_check', [ApiController::class, 'email_check']);
Route::POST('/password_verify_code', [ApiController::class, 'password_verify_code']);
Route::POST('/change_password', [ApiController::class, 'change_password']);
