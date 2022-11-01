<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    use HasFactory;
    protected $table = "pedido";

    protected $fillable = [
        'orden_compra',
        'direccion',
        'proceso',
        'id_cliente',
        'id_usuario',
        // 'calificacion',
        // 'bitacora',
    ];
}
