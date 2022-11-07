<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pedido;
use Illuminate\Http\Request;

class pedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear_pedido(Request $request)
    {
        // Cliente crea pedidos
        $request->validate([
            'orden_compra' => 'required|string',
            'direccion' => 'required|string',
            'id_cliente' => 'required|numeric|integer',
        ]);
        $pedido = new pedido();
        $pedido->orden_compra = $request->orden_compra;
        $pedido->id_cliente = $request->id_cliente;
        $pedido->direccion = $request->direccion;
        $pedido->save();
        return response()->json([
            "status" =>200,
            "msg" => "pedido creado correctamente"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editar_pedido(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|integer',
            'orden_compra' => 'required|string',
            'direccion' => 'required|string',
        ]);
        // Cliente edita el pedido
        $pedido = pedido::where("id", "=", $request->id)->first();
        $pedido->orden_compra = $request->orden_compra;
        $pedido->direccion = $request->direccion;
        $pedido->save();
        return response()->json([
            "status" =>200,
            "msg" => "pedido editado correctamente"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cliente_pedidos()
    {
        // Listar los pedidos del cliente y del empleado
        $id = auth()->user()->id;
        $pedidos = pedido::where('id_cliente', '=', $id)::all();
        return response()->json([
            "status" =>200,
            "msg" => "Lista completa",
            "result" => $pedidos
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all_pedidos()
    {
        // Mostrar todos los pedidos
        $pedidos = pedido::all();
        return response()->json([
            "status" =>200,
            "msg" => "Lista completa",
            "result" => $pedidos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asignar_pedido(Request $request)
    {
        // Asignar pedido a empleado
        $pedido = pedido::where("id", "=", $request->id)->first();
        $pedido->id_usuario = auth()->user()->id;
        $pedido->save();
        return response()->json([
            "status" => 200,
            "msg" => "pedido asignado correctamente"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function proceso_pedido(Request $request)
    {
        // Cambiar proceso
        $pedido = pedido::where("id", "=", $request->id)->first();
        $pedido->proceso = $request->proceso;
        $pedido->save();
        return response()->json([
            "status" => 200,
            "msg" => "proceso actualizado correctamente"
        ]);
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
