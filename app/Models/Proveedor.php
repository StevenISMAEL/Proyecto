<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'ruc';
    public $timestamps = true; // Habilita las marcas de tiempo

    protected $fillable = [
        'ruc',
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'activo',
        'notas_proveedor'
    ];
}

