<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

class clienteController extends Controller
{
    // Registro de usuario
    public function register(Request $request){
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:cliente',
            'telefono' => 'required|string|min:10',
            'razon_social' => 'required|string',
            'RFC' => 'required|string',
            'direccion' => 'required|string',
            'password' => 'required|confirmed'
        ]);
        $cliente = new cliente();
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->razon_social = $request->razon_social;
        $cliente->RFC = $request->RFC;
        $cliente->password = Hash::make($request->password);
        $cliente->save();

        return response()->json([
            "status" =>200,
            "msg" => "$cliente->email, registrado correctamente"
        ]);
    }
    // Loguear usuario
    public function login(Request $request){
        $request->validate([
            "email"=>'required|email',
            "password"=>'required'
        ]);
        $cliente = cliente::where("email", "=", $request->email)->first();
        if (isset($cliente->id)) {
            if (Hash::check($request->password, $cliente->password)) {
                $token = $cliente->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => 200,
                    "msg" => "Usuario logueado",
                    "rol" => "cliente",
                    "access_token" => $token
                ]);
            }else{
                return response()->json([
                    "status" => 401,
                    "msg" => "Contraseña incorrecta"
                ]);
            }
        }else{
            return response()->json([
                "status" => 404,
                "msg" => "El usuario no esta registrado"
            ]);
        }
    }
    // Logout usuario
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 200,
            "msg" => "Sesion cerrada correctamente",
        ]);
    }
    // Perfil del usuario
    public function profile(){
        return response()->json([
            "status" => 200,
            "msg" => "Peticion resuelta",
            "result" => auth()->user()
        ]);
    }

    // Listar a todos los clientes
    public function all_clientes(){
        $clientes = cliente::all();
        return response()->json([
            "status" => 200,
            "msg" => "Peticion resuelta",
            "result" => $clientes
        ]);
    }
    // Dar de baja cliente
    public function estatus_cliente(Request $request){
        $nuevo_estatus = ($request->estatus_actual == true) ? false : true;
        $aviso = ($request->estatus_actual == true) ? "baja" : "alta";
        $clientes = cliente::where("id", "=", $request->id)->first();
        if (isset($clientes->estatus)) {
            # code...
            $clientes->estatus = $nuevo_estatus;
            $clientes->save();
            return response()->json([
                "status" => 200,
                "msg" => "Cliente dado de $aviso correctamente",
            ]);
        }else{
            return response()->json([
                "status" => 404,
                "msg" => "cliente no existe",
            ]);
        }
    }
    // Editar cliente solo cliente
    public function editar_cliente(Request $request){
        $request->validate([
            'nombre' => 'sometimes',
            'email' => 'sometimes|email|unique:cliente',
            'telefono' => 'sometimes|string|min:10',
            'razon_social' => 'sometimes|string',
            'RFC' => 'sometimes|string',
            'direccion' => 'sometimes|string',
            'password' => 'sometimes|confirmed'
        ]);
        $cliente = cliente::where('email', '=', $request->email)->first();
        if (isset($cliente->email)) {
            if (Hash::check($request->password, $cliente->password)) {
                $cliente->nombre = $request->nombre;
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->rol = $request->rol;
                $cliente->password = Hash::make($request->password);
                $cliente->estatus = $request->estatus;
                $cliente->save();
                return response()->json([
                    "status" =>200,
                    "msg" => "$cliente->nombre, modificado correctamente"
                ]);
            }else{
                return response()->json([
                    "status" =>403,
                    "msg" => "Contraseña incorrecta"
                ]);
            }
        }else{
            return response()->json([
                "status" =>404,
                "msg" => "Cliente no registrado"
            ]);
        }
    }
}