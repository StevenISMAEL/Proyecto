<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los proveedores, ordenados por fecha de registro descendente
        $proveedores = Proveedor::orderBy('nombre', 'DESC')->paginate(3);
        return view('proveedor.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Muestra la vista para crear un nuevo proveedor
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'ruc' => 'required|string|size:13|unique:proveedores', 
            'nombre' => 'required|string|max:100',
            'correo' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
            'notas_proveedor'=> 'required|string|max:500',
            
        ]);

        // Crear el proveedor con los datos validados
        Proveedor::create($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $ruc
     * @return \Illuminate\Http\Response
     */
    public function show($ruc)
    {
        // Obtener el proveedor por su RUC
        $proveedor = Proveedor::findOrFail($ruc);
        return view('proveedor.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $ruc
     * @return \Illuminate\Http\Response
     */
    public function edit($ruc)
    {
        // Buscar al proveedor por RUC
        $proveedor = Proveedor::findOrFail($ruc);
        return view('proveedor.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ruc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ruc)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
            'notas_proveedor'=> 'required|string|max:500',
        ]);

        // Buscar el proveedor por su RUC
        $proveedor = Proveedor::findOrFail($ruc);

        // Actualizar los campos del proveedor con los datos del formulario
        $proveedor->nombre = $request->input('nombre');
        $proveedor->correo = $request->input('correo');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->activo = $request->input('activo');
        $proveedor->notas_proveedor = $request->input('notas_proveedor');


        // Guardar los cambios en la base de datos
        $proveedor->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $ruc
     * @return \Illuminate\Http\Response
     */
    public function destroy($ruc)
    {
        // Eliminar el proveedor por su RUC
        Proveedor::findOrFail($ruc)->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado satisfactoriamente');
    }


}