<?php

use App\Http\Controllers\Api\clienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use GuzzleHttp\Middleware;

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

Route::group(['middleware' => ['cors']], function () {
    // Aqui entran peticiones desde cualquier cors
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('register_user', [clienteController::class, 'register']);
    Route::post('login_user', [clienteController::class, 'login']);
    // Aqui entran solo peticiones que esten autenticadas
    Route::group( ['middleware' => ['auth:sanctum']], function(){
        Route::get('profile', [UserController::class, 'profile']);
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('logout_user', [clienteController::class, 'logout']);
        Route::get('profile_user', [clienteController::class, 'profile']);
        Route::group(['middleware' => ['rol']], function(){
            Route::get('all_users', [UserController::class, 'all_users']);
        });
    });
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});