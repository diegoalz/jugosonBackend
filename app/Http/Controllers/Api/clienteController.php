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
            "user_info" => auth()->user()
        ]);
    }

}