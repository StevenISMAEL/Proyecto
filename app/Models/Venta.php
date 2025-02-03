<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $primaryKey = 'id_ven'; // Establece la clave primaria
    public $incrementing = false; // Desactiva el incremento automático
    protected $keyType = 'string'; // Define el tipo de la clave primaria como 'string' si es necesario

    protected $fillable = [
        'id_ven',
        'cedula_cli',
        'nombre_cli_ven',
        'fecha_emision_ven',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_ven', 'id_ven');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cedula_cli', 'cedula_cli');
    }

    /**
     * Scope para obtener las ventas agrupadas por mes.
     */
    public function scopeVentasPorMes($query)
    {
        return $query->selectRaw("EXTRACT(MONTH FROM fecha_emision_ven) as mes, 
                                  SUM(detalles_ventas.cantidad_pro_detven * detalles_ventas.precio_unitario_detven * 
                                  (1 + detalles_ventas.iva_detven / 100)) as total_venta")
                     ->join('detalles_ventas', 'detalles_ventas.id_ven', '=', 'ventas.id_ven')
                     ->groupBy(DB::raw("EXTRACT(MONTH FROM fecha_emision_ven)"))
                     ->orderBy('mes');
    }
}
