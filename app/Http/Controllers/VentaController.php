<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'venta.id_ven' => 'required|numeric|digits:13|unique:ventas,id_ven',
            'venta.cedula_cli' => 'required|string|exists:clientes,cedula_cli',
            'venta.fecha_emision_ven' => 'required|date',
            'detalles.*.id_detven' => 'required|string|max:15|unique:detalles_ventas,id_detven',
            'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detven' => 'required|numeric|min:1',
            'detalles.*.precio_unitario_detven' => 'required|numeric|min:0',
            'detalles.*.iva_detven' => 'required|numeric|min:0|max:100',
        ]);
    
        $cliente = Cliente::where('cedula_cli', $validated['venta']['cedula_cli'])->first();
    
        $venta = Venta::create([
            'id_ven' => $validated['venta']['id_ven'],
            'cedula_cli' => $validated['venta']['cedula_cli'],
            'nombre_cli_ven' => $cliente ? $cliente->nombre_cli : null,
            'fecha_emision_ven' => $validated['venta']['fecha_emision_ven'],
        ]);
    
        foreach ($request->detalles as $detalle) {
            $venta->detalles()->create([
                'id_detven' => $detalle['id_detven'],
                'codigo_pro' => $detalle['codigo_pro'],
                'nombre_producto_detven' => Producto::where('codigo_pro', $detalle['codigo_pro'])->first()->nombre_pro,
                'cantidad_pro_detven' => $detalle['cantidad_pro_detven'],
                'precio_unitario_detven' => $detalle['precio_unitario_detven'],
                'iva_detven' => $detalle['iva_detven'],
            ]);
        }
        
    
        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }
    public function edit($id)
{
    $venta = Venta::with('detalles')->findOrFail($id); // Carga la venta con sus detalles
    $clientes = Cliente::all(); // Obtiene todos los clientes
    $productos = Producto::all(); // Obtiene todos los productos

    return view('ventas.edit', compact('venta', 'clientes', 'productos'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'venta.fecha_emision_ven' => 'required|date',
        'detalles.*.id_detven' => 'required|string|max:15|unique:detalles_ventas,id_detven,' . $id . ',id_ven',
        'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
        'detalles.*.cantidad_pro_detven' => 'required|numeric|min:1',
        'detalles.*.precio_unitario_detven' => 'required|numeric|min:0',
        'detalles.*.iva_detven' => 'required|numeric|min:0|max:100',
    ]);

    $venta = Venta::findOrFail($id); // Busca la venta por ID
    $venta->update([
        'fecha_emision_ven' => $validated['venta']['fecha_emision_ven'],
    ]);

    // Actualizar o crear detalles de la venta
    foreach ($request->detalles as $detalle) {
        DetalleVenta::updateOrCreate(
            ['id_detven' => $detalle['id_detven']], // Condición para actualizar
            [
                'id_ven' => $venta->id_ven,
                'codigo_pro' => $detalle['codigo_pro'],
                'nombre_producto_detven' => Producto::where('codigo_pro', $detalle['codigo_pro'])->first()->nombre_pro,
                'cantidad_pro_detven' => $detalle['cantidad_pro_detven'],
                'precio_unitario_detven' => $detalle['precio_unitario_detven'],
                'iva_detven' => $detalle['iva_detven'],
            ]
        );
    }

    return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
}

    


    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->detalles()->delete();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
}
