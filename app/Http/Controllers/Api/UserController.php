<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Registrar ususario
    public function register(Request $request){
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required|string|min:10',
            'rol' => 'required|string',
            'password' => 'required|confirmed'
        ]);
        $user = new User();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->telefono = $request->telefono;
        $user->rol = $request->rol;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "status" =>200,
            "msg" => "$user->rol, registrado correctamente"
        ]);
    }
    // Loguear usuario
    public function login(Request $request){
        $request->validate([
            "email"=>'required|email',
            "password"=>'required'
        ]);
        $user = User::where("email", "=", $request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
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
    // Ver todos los usuarios (solo admin)
    public function all_users(){
        $usuarios = User::all();
        return response()->json([
            "status" => 200,
            "msg" => "Peticion resuelta",
            "user_info" => $usuarios
        ]);
    }
    // Cambiar estatus de los usuarios
    public function estatus_users(Request $request){
        $nuevo_estatus = ($request->estatus_actual == true) ? false : true;
        $aviso = ($request->estatus_actual == true) ? "baja" : "alta";
        $user = User::where("id", "=", $request->id)->first();
        if (isset($user->estatus)) {
            # code...
            $user->estatus = $nuevo_estatus;
            $user->save();
            return response()->json([
                "status" => 200,
                "msg" => "usuario dado de $aviso correctamente",
            ]);
        }else{
            return response()->json([
                "status" => 404,
                "msg" => "usuario no existe",
            ]);
        }
    }
    // Editar un usuario
    public function editar_users(Request $request){
        $request->validate([
            'nombre' => 'sometimes',
            'email' => 'sometimes|email',
            'telefono' => 'sometimes|string|min:10',
            'rol' => 'sometimes|string',
            'password' => 'sometimes|confirmed',
            'estatus' => 'sometimes|boolean'
        ]);
        $user = new User();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->telefono = $request->telefono;
        $user->rol = $request->rol;
        $user->password = Hash::make($request->password);
        $user->estatus = $request->estatus;
        $user->save();
        return response()->json([
            "status" =>200,
            "msg" => "$user->nombre, modificado correctamente"
        ]);
    }
}
