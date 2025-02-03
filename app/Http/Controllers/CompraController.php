<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\Producto;


class CompraController extends Controller
{
    public function Menu()
{
    // Obtener las compras agrupadas por mes
    $compras = Compra::comprasPorMes()->get();

    // Pasar las compras a la vista para mostrar en el gráfico
    return view('compras.index', compact('compras'));
}


    public function index()
    {
        $compras = Compra::with('detalles')->paginate(10); // Obtener compras con sus detalles
        return view('compras.index', compact('compras'));
    }


    public function create()
    {
        // Obtener todos los proveedores
        $proveedores = Proveedor::all();
        // Obtener todos los productos
        $productos = Producto::all();

        return view('compras.create', compact('proveedores'), compact('productos'));
    }



    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'compra' => 'required|array',
            'compra.id_com' => 'required|string|max:15|unique:compras,id_com',
            'compra.ruc_pro' => 'required|string|max:13|exists:proveedores,ruc',
            'compra.fecha_emision_com' => 'required|date',
            'compra.nombre_proveedor_com' => 'required|string|max:100',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_detcom' => 'required|string|max:15|unique:detalles_compras,id_detcom',
            'detalles.*.codigo_pro' => 'nullable|string|max:15',
            'detalles.*.nombre_producto_detcom' => 'required|string|max:100',
            'detalles.*.cantidad_pro_detcom' => 'required|integer|min:1',
            'detalles.*.precio_unitario_detcom' => 'required|numeric|min:0',
            'detalles.*.iva_detcom' => 'required|numeric|min:0',
        ]);

        $compraData = $request->input('compra');
        $detallesData = $request->input('detalles');

        DB::beginTransaction();

        try {
            // Crear la compra
            $compra = Compra::create($compraData);

            // Crear los detalles asociados
            foreach ($detallesData as $detalle) {
                $detalle['id_com'] = $compra->id_com; // Relacionar con la compra
                DetalleCompra::create($detalle);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compra y detalles guardados exitosamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la compra y sus detalles.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function edit($id)
    {
        // Obtén el detalle de la compra a editar
        $compra = Compra::findOrFail($id);

        // Asegúrate de que los ruc y código del producto sean tratados como strings
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        // Si estás tratando con un número, conviértelo a string explícitamente en el controller
        $compra->ruc_pro = strval($compra->ruc_pro);

        // Pasar los datos a la vista
        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }


    /**
     * Actualizar una compra existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id_com
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id_com)
    {
        $request->validate([
            'compra' => 'required|array',
            'compra.id_com' => 'required|string|max:15|unique:compras,id_com,' . $id_com . ',id_com',
            'compra.ruc_pro' => 'required|string|max:13|exists:proveedores,ruc',
            'compra.fecha_emision_com' => 'required|date',
            'compra.nombre_proveedor_com' => 'required|string|max:100',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_detcom' => 'required|string|max:15',
            'detalles.*.codigo_pro' => 'nullable|string|max:15',
            'detalles.*.nombre_producto_detcom' => 'required|string|max:100',
            'detalles.*.cantidad_pro_detcom' => 'required|integer|min:1',
            'detalles.*.precio_unitario_detcom' => 'required|numeric|min:0',
            'detalles.*.iva_detcom' => 'required|numeric|min:0',
        ]);

        $compraData = $request->input('compra');
        $detallesData = $request->input('detalles');

        DB::beginTransaction();

        try {
            $compra = Compra::findOrFail($id_com);
            $compra->update($compraData);

            // Eliminar los detalles existentes
            DetalleCompra::where('id_com', $id_com)->delete();

            // Crear los nuevos detalles asociados
            foreach ($detallesData as $detalle) {
                $detalle['id_com'] = $compra->id_com;
                DetalleCompra::create($detalle);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compra y detalles actualizados exitosamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la compra y sus detalles.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar una compra y sus detalles.
     *
     * @param  string  $id_com
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id_com)
    {
        DB::beginTransaction();

        try {
            DetalleCompra::where('id_com', $id_com)->delete();
            Compra::where('id_com', $id_com)->delete();

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra y detalles eliminados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la compra: ' . $e->getMessage()]);
        }
    }
}
