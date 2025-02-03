<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'productos';

    // Clave primaria
    protected $primaryKey = 'codigo_pro';

    // Clave primaria no incremental (UUID o similar)
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'string';

    // Campos asignables en la tabla
    protected $fillable = [
        'codigo_pro',
        'nombre_pro',
        'descripcion_pro',
        'alimenticio_pro',
        'precio_unitario_pro'
    ];

    // Relación uno a muchos: un producto tiene muchos detalles
    public function detalles()
    {
        return $this->hasMany(DetalleProducto::class, 'codigo_pro', 'codigo_pro');
    }
    public function kardex()
{
    return $this->hasMany(Kardex::class, 'codigo_pro', 'codigo_pro');
}

}
