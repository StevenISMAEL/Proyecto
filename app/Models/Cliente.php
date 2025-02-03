<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'clientes';

    // Definir la clave primaria
    protected $primaryKey = 'cedula_cli'; // Se usa la cédula como clave primaria

    // Deshabilitar la auto-incrementación, ya que usas una clave primaria no autoincrementable
    public $incrementing = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'cedula_cli',
        'nombre_cli',
        'direccion_cli',
        'telefono_cli',
        'correo_cli',
        'fecha_registro_cli',
    ];

    // Puedes agregar relaciones si es necesario, por ejemplo, con ventas
}

