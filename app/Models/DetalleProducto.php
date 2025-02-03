<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'detalles_producto';

    // Clave primaria
    protected $primaryKey = 'id_detpro';

    // Desactivamos los timestamps automáticos (opcional)
    public $timestamps = false;

    // Clave primaria no es autoincremental
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // Campos asignables en la tabla
    protected $fillable = [
        'id_detpro',
        'codigo_pro',
        'tipo_animal_detpro',
        'tamano_raza_detpro',
        'peso_libras_detpro',
        'precio_libras_detpro'
    ];

    // Relación inversa: un detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
