<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $primaryKey = 'id_com';
    public $incrementing = false; // Dado que es un string, no es auto-incremental
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_com',
        'ruc_pro',
        'fecha_emision_com',
        'nombre_proveedor_com',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ruc_pro', 'ruc');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_com', 'id_com');
    }

    public function scopeComprasPorMes($query)
    {
        return $query->selectRaw("EXTRACT(MONTH FROM fecha_emision_com) as mes, 
                                  SUM(detalles_compras.cantidad_pro_detcom * detalles_compras.precio_unitario_detcom * 
                                  (1 + detalles_compras.iva_detcom / 100)) as total_compra")
                     ->join('detalles_compras', 'detalles_compras.id_com', '=', 'compras.id_com')
                     ->groupBy(DB::raw("EXTRACT(MONTH FROM fecha_emision_com)"))
                     ->orderBy('mes');
    }
    

}
