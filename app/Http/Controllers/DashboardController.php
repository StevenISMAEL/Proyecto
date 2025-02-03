<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\Compra;

class DashboardController extends Controller
{
    public function menu()
    {
        // Obtener los 5 productos más recientes
        $productos = Producto::latest()->take(5)->get();
    
        // Obtener las 5 ventas más recientes con sus detalles
        $ventas = Venta::with('detalles')->latest()->take(5)->get();
    
        // Obtener las 5 compras más recientes con sus detalles
        $compras = Compra::with('detalles')->latest()->take(5)->get();
    
        // Obtener el total de ventas por mes (formato: [enero, febrero, ...])
        $ventasPorMes = Venta::ventasPorMes()->pluck('total_venta')->toArray();

        // Obtener el total de compras por mes (formato: [enero, febrero, ...])
        $comprasPorMes = Compra::comprasPorMes()->pluck('total_compra')->toArray();
        
        // Retornar los datos a la vista del menú
        return view('menu', compact('productos', 'ventas', 'compras', 'ventasPorMes', 'comprasPorMes'));
    }
}
