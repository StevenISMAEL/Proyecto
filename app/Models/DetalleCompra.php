<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalles_compras';

    protected $primaryKey = 'id_detcom';
    public $incrementing = false; // Dado que es un string, no es auto-incremental
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_detcom',
        'codigo_pro',
        'id_com',
        'nombre_producto_detcom',
        'cantidad_pro_detcom',
        'precio_unitario_detcom',
        'iva_detcom',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_com', 'id_com');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
