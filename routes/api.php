<?php

use App\Http\Controllers\Api\clienteController;
use App\Http\Controllers\Api\pedido_productoController;
use App\Http\Controllers\Api\pedidoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\productoController;

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
    Route::post('login', [UserController::class, 'login']);
    Route::post('client_register', [clienteController::class, 'register']);
    Route::post('client_login', [clienteController::class, 'login']);
    // Peticiones permitidas para gente que esta autenticada
    Route::group( ['middleware' => ['auth:sanctum']], function(){
        Route::get('profile', [UserController::class, 'profile']);
        Route::get('logout', [UserController::class, 'logout']);
        // Repartidor
        Route::post('proceso_pedido', [pedidoController::class, 'proceso_pedido']); // Cambiar el proceso en general
        Route::post('lista_pedido_producto', [pedido_productoController::class, 'lista_pedido_producto']);
        Route::get('repartidor_pedidos', [pedidoController::class, 'repartidor_pedidos']);
        Route::get('porHacer', [pedidoController::class, 'porHacer']);
        // Aqui entran solo las peticiones con el rol de empleado y admin
        Route::group(['middleware' => ['usuario']], function(){
            // Aqui entran solo las peticiones con rol admin
            Route::post('asignar_pedido', [pedidoController::class, 'asignar_pedido']); // Para que un empleado se asigne
            Route::group(['middleware' => ['admin']], function(){
                // Control de los usuarios
                Route::get('all_users', [UserController::class, 'all_users']);
                Route::post('estatus_users', [UserController::class, 'estatus_users']);
                Route::post('editar_users', [UserController::class, 'editar_users']);
                Route::post('register', [UserController::class, 'register']);
                // Control de clientes
                Route::get('all_clientes', [clienteController::class, 'all_clientes']);
                // Control completo del catalogo de productos
                Route::post('guardar_producto', [productoController::class, 'guardar_producto']);
                Route::post('editar_producto', [productoController::class, 'editar_producto']);
                Route::post('producto_baja', [productoController::class, 'producto_baja']);
                Route::get('all_producto', [productoController::class, 'all_producto']);
                // Control completo de los pedidos
                Route::get('all_pedidos', [pedidoController::class, 'all_pedidos']);
                // Control completo de pedido_productos
            });
        });
        // Aqui entran solo las peticiones que puede hacer un cliente
        Route::group(['middleware' => ['cliente']], function(){
            // Control de la cuenta
            Route::get('client_logout', [clienteController::class, 'logout']);
            Route::get('client_profile', [clienteController::class, 'profile']);
            Route::post('estatus_cliente', [clienteController::class, 'estatus_cliente']);
            Route::post('editar_cliente', [clienteController::class, 'editar_cliente']);
            // Visualizacion del producto
            Route::get('catalogo', [productoController::class, 'catalogo']);
            // Realizar pedido
            Route::post('crear_pedido', [pedidoController::class, 'crear_pedido']);
            Route::post('editar_pedido', [pedidoController::class, 'editar_pedido']);
            Route::get('cliente_pedidos', [pedidoController::class, 'cliente_pedidos']);
            // Control de los productos pedidos
            Route::post('agregar_pedido_producto', [pedido_productoController::class, 'agregar_pedido_producto']);
            Route::post('eliminar_pedido_producto', [pedido_productoController::class, 'eliminar_pedido_producto']);
        });
    });
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});