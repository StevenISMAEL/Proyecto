<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';

    protected $primaryKey = 'id_detven'; // Establece la clave primaria
    public $incrementing = false; // Desactiva el incremento automático
    protected $keyType = 'string'; // Define el tipo de la clave como string si es necesario

    protected $fillable = [
        'id_detven',
        'id_ven',
        'codigo_pro',
        'nombre_producto_detven',
        'cantidad_pro_detven',
        'precio_unitario_detven',
        'iva_detven',
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
