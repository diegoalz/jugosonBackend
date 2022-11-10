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
        ]);
        $pedido = new pedido();
        $pedido->orden_compra = $request->orden_compra;
        $pedido->id_cliente = auth()->user()->id;
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
        if (isset($pedido->id)) {
            $pedido->orden_compra = $request->orden_compra;
            $pedido->direccion = $request->direccion;
            $pedido->save();
            return response()->json([
                "status" =>200,
                "msg" => "pedido editado correctamente"
            ]);
        }else{
            return response()->json([
                "status" =>404,
                "msg" => "el pedido no existe"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cliente_pedidos()
    {
        // Listar los pedidos del cliente
        $id = auth()->user()->id;
        $pedidos = pedido::where('id_cliente', '=', $id)->get(); // Esta es la forma correcta de hacerlo
        return response()->json([
            "status" =>200,
            "msg" => "Lista completa",
            "result" => $pedidos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function repartidor_pedidos()
    {
        // Listar los pedidos del repartidor
        $id = auth()->user()->id;
        $pedidos = pedido::all();
        $pedidos = $pedidos->where('id_usuario', '=', $id)->where('estatus', '=', true);
        return response()->json([
            "status" =>200,
            "msg" => "Lista completa",
            "result" => $pedidos
        ]);
    }
    public function porHacer()
    {
        // Listar los pedidos por hacer para los empleados
        $pedidos = pedido::all();
        $pedidos = $pedidos->where('proceso', '=', 'en espera')->where('estatus', '=', true);
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
        $pedido = pedido::all();
        $pedido = $pedido->where("id", "=", $request->id)->first();
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
        $pedido = pedido::all();
        $pedido = $pedido->where("id", "=", $request->id)->first();
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
