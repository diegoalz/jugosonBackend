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
// Este middleware le permite recibir peticiones de todos lados
Route::group(['middleware' => ['cors']], function () {
    // Peticiones permitidas para gente sin autenticar
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('client_register', [clienteController::class, 'register']);
    Route::post('client_login', [clienteController::class, 'login']);
    // Peticiones permitidas para gente que esta autenticada
    Route::group( ['middleware' => ['auth:sanctum']], function(){
        Route::get('profile', [UserController::class, 'profile']);
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('client_logout', [clienteController::class, 'logout']);
        Route::get('client_profile', [clienteController::class, 'profile']);
        // Aqui entran solo las peticiones con el rol de empleado y admin
        Route::group(['middleware' => ['usuario']], function(){
            // Aqui entran solo las peticiones con rol admin
            Route::group(['middleware' => ['admin']], function(){
                Route::get('all_users', [UserController::class, 'all_users']);
            });
        });
    });
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});