<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pedido_producto;
use Illuminate\Http\Request;

class pedido_productoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agregar_pedido_producto(Request $request)
    {
        // Agregar un producto al pedido
        $request->validate([
            'id_pedido' => 'required|numeric|integer',
            'id_producto' => 'required|numeric|integer',
            'precio_unitario' => 'required|numeric',
            'cantidad' => 'required|numeric|integer',
        ]);
        $pedido_producto = new pedido_producto();
        $pedido_producto->id_pedido = $request->id_pedido;
        $pedido_producto->id_producto = $request->id_producto;
        $pedido_producto->precio_unitario = $request->precio_unitario;
        $pedido_producto->cantidad = $request->cantidad;
        $pedido_producto->save();
        return response()->json([
            "status" =>200,
            "msg" => "producto agregado correctamente"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eliminar_pedido_producto(Request $request)
    {
        // Eliminar un producto del pedido
        $pedido_eliminar = pedido_producto::find($request->id);
        if (isset($pedido_eliminar->id)) {
            $pedido_eliminar->delete();
            return response()->json([
                "status" =>200,
                "msg" => "producto eliminado correctamente de la lista"
            ]);
        }else{
            return response()->json([
                "status" =>403,
                "msg" => "ese producto no existe en el pedido"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lista_pedido_producto(Request $request)
    {
        $productos_pedido = pedido_producto::where('id_pedido', '=', $request->id_pedido)->get();
        if(isset($productos_pedido[0]->id)){
            return response()->json([
                "status" =>200,
                "msg" => "lista encontrada",
                "result" => $productos_pedido
            ]);
        }else{
            return response()->json([
                "status" =>403,
                "msg" => "el pedido no cuenta con producto asignados",
            ]);
        }
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
