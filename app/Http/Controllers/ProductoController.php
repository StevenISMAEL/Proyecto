<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\DetalleProducto;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de productos.
     *
     * @return \Illuminate\View\Response
     */
    public function index()
    {
        // Obtener todos los productos, puedes aplicar paginación si lo deseas
        $productos = Producto::with('detalles')->paginate(10);
        return view('producto.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('producto.create');
    }

    // public function store(Request $request)
    // {
    //     // Validar los datos
    //     $request->validate([
    //         'producto' => 'required|array',
    //         'producto.codigo_pro' => 'required|string|max:15|unique:productos,codigo_pro',
    //         'producto.nombre_pro' => 'required|string|max:50',
    //         'producto.descripcion_pro' => 'nullable|string|max:100',
    //         'producto.alimenticio_pro' => 'required|boolean',
    //         'producto.precio_unitario_pro' => 'required|numeric|min:0',
    //         'detalles' => 'required|array|min:1',
    //         'detalles.*.id_detpro' => 'required|string|max:20|unique:detalles_producto,id_detpro',
    //         'detalles.*.tipo_animal_detpro' => 'required|string|max:20',
    //         'detalles.*.tamano_raza_detpro' => 'nullable|string|max:20',
    //         'detalles.*.peso_libras_detpro' => 'nullable|numeric|min:0',
    //         'detalles.*.precio_libras_detpro' => 'nullable|numeric|min:0',
    //     ]);

    //     $productoData = $request->input('producto'); // Datos de la tabla Producto
    //     $detallesData = $request->input('detalles'); // Datos de la tabla DetalleProducto

    //     // Iniciar la transacción
    //     DB::beginTransaction();

    //     try {
    //         // Crear el producto
    //         $producto = Producto::create($productoData);

    //         // Crear los detalles asociados
    //         foreach ($detallesData as $detalle) {
    //             $detalle['codigo_pro'] = $producto->codigo_pro; // Relacionar con el producto
    //             DetalleProducto::create($detalle);
    //         }

    //         // Confirmar la transacción
    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Producto y detalles guardados exitosamente.',
    //         ]);
    //     } catch (\Exception $e) {
    //         // Revertir la transacción en caso de error
    //         DB::rollBack();

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al guardar el producto y sus detalles.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // Almacenar un nuevo producto
public function store(Request $request)
{
    // Validación
    $request->validate([
        'producto' => 'required|array',
        'producto.codigo_pro' => 'required|string|max:15|unique:productos,codigo_pro',
        'producto.nombre_pro' => 'required|string|max:50',
        'producto.descripcion_pro' => 'nullable|string|max:100',
        'producto.alimenticio_pro' => 'required|boolean',
        'producto.precio_unitario_pro' => 'required|numeric|min:0',
        'detalles' => 'required|array|min:1', // Asegurarte que siempre haya un detalle
        'detalles.0.id_detpro' => 'required|string|max:20|unique:detalles_producto,id_detpro',
        'detalles.0.tipo_animal_detpro' => 'required|string|max:20',
        'detalles.0.tamano_raza_detpro' => 'nullable|string|max:20',
        'detalles.0.peso_libras_detpro' => 'nullable|numeric|min:0',
        'detalles.0.precio_libras_detpro' => 'nullable|numeric|min:0',
    ]);

    // Datos del producto
    $productoData = $request->input('producto');
    $detallesData = $request->input('detalles');

    DB::beginTransaction();

    try {
        // Crear el producto
        $producto = Producto::create($productoData);

        // Crear el detalle asociado
        $detalle = $detallesData[0];  // Solo se maneja el primer detalle (índice 0)
        $detalle['codigo_pro'] = $producto->codigo_pro;
        DetalleProducto::create($detalle);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Producto y detalles guardados exitosamente.',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar el producto y sus detalles.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function edit($codigo)
    {
        $producto = Producto::with('detalles')->findOrFail($codigo);
        return view('producto.edit', compact('producto'));
    }
    

 



    public function update(Request $request, $codigo)
    {
        // Validar los datos de entrada
        $request->validate([
            'producto' => 'required|array',
            'producto.codigo_pro' => 'required|string|max:15|unique:productos,codigo_pro,' . $codigo . ',codigo_pro',
            'producto.nombre_pro' => 'required|string|max:50',
            'producto.descripcion_pro' => 'nullable|string|max:100',
            'producto.alimenticio_pro' => 'required|boolean',
            'producto.precio_unitario_pro' => 'required|numeric|min:0',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_detpro' => 'required|string|max:20',
            'detalles.*.tipo_animal_detpro' => 'required|string|max:20',
            'detalles.*.tamano_raza_detpro' => 'nullable|string|max:20',
            'detalles.*.peso_libras_detpro' => 'nullable|numeric|min:0',
            'detalles.*.precio_libras_detpro' => 'nullable|numeric|min:0',
        ]);

        $productoData = $request->input('producto'); // Datos de la tabla Producto
        $detallesData = $request->input('detalles'); // Datos de la tabla DetalleProducto

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Buscar el producto por su código
            $producto = Producto::findOrFail($codigo);

            // Actualizar los datos del producto
            $producto->update($productoData);

            // Eliminar los detalles existentes antes de agregar los nuevos
            DetalleProducto::where('codigo_pro', $producto->codigo_pro)->delete();

            // Crear los nuevos detalles asociados
            foreach ($detallesData as $detalle) {
                $detalle['codigo_pro'] = $producto->codigo_pro; // Relacionar con el producto
                DetalleProducto::create($detalle);
            }

            // Confirmar la transacción
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto y detalles actualizados exitosamente.',
            ]);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto y sus detalles.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Eliminar un producto de la base de datos.
     *
     * @param  string  $codigo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($codigo)
    {
        DB::beginTransaction();

        try {
            $producto = Producto::where('codigo_pro', $codigo)->firstOrFail();
            DetalleProducto::where('codigo_pro', $codigo)->delete();
            $producto->delete();

            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto y sus detalles eliminados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }
}
