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
            'email' => 'required|email|unique:users',
            'telefono' => 'required|string',
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
            "status" => 1,
            "msg" => "$user->rol, registrado correctamente"
        ]);
    }
    // Loguear usuario
    public function login(Request $request){
        
    }
    // Logout usuario
    public function logout(){
        
    }
    // Perfil del usuario
    public function profile(){
        
    }
}
