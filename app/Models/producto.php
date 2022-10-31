<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;
    protected $table = "producto";

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio_actual'
    ];
}
