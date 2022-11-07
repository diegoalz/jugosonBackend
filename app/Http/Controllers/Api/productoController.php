<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar_producto(Request $request)
    {
        //Agregar un producto al catalogo
        $request->validate([
            'nombre_producto' => 'required|string',
            'descripcion' => 'required|string',
            'precio_actual' => 'required|numeric'
        ]);
        $producto = new producto();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion = $request->descripcion;
        $producto->precio_actual = $request->precio_actual;
        $producto->save();
        return response()->json([
            "status" =>200,
            "msg" => "$producto->nombre_producto, registrado correctamente"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editar_producto(Request $request)
    {
        // Editar un producto por id
        $request->validate([
            'id' => 'required|numeric|integer',
            'nombre_producto' => 'required|string',
            'descripcion' => 'required|string',
            'precio_actual' => 'required|numeric'
        ]);
        $producto = producto::where("id", "=", $request->id)->first();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion = $request->descripcion;
        $producto->precio_actual = $request->precio_actual;
        $producto->save();
        return response()->json([
            "status" =>200,
            "msg" => "$producto->nombre_producto, actualizado correctamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function produco_baja(Request $request)
    {
        $nuevo_estatus = ($request->estatus_actual == true) ? false : true;
        $aviso = ($request->estatus_actual == true) ? "baja" : "alta";
        $producto = producto::where("id", "=", $request->id)->first();
        if (isset($producto->estatus)) {
            # code...
            $producto->estatus = $nuevo_estatus;
            $producto->save();
            return response()->json([
                "status" => 200,
                "msg" => "El producto fue dado de $aviso correctamente",
            ]);
        }else{
            return response()->json([
                "status" => 404,
                "msg" => "El producto no existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function catalogo()
    {
        // Lista producto solo para clientes
        $productos = producto::where("estatus", "=", true)::all();
        return response()->json([
            "status" => 200,
            "msg" => "Peticion resuelta",
            "result" => $productos
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all_producto()
    {
        // Lista de productos completa para el administrador
        $producto = producto::all();
        return response()->json([
            "status" => 200,
            "msg" => "Peticion resuelta",
            "result" => $producto
        ]);
    }
}