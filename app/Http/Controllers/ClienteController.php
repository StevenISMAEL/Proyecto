<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Mostrar lista de clientes
    public function index()
    {
        $clientes = Cliente::paginate(10); // Paginación para mostrar 10 clientes por página
        return view('clientes.index', compact('clientes'));
    }

    // Mostrar formulario para crear un nuevo cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Almacenar un nuevo cliente en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'cedula_cli' => 'required|unique:clientes,cedula_cli|max:10',
            'nombre_cli' => 'required|max:100',
            'direccion_cli' => 'nullable|max:150',
            'telefono_cli' => 'required|max:10',
            'correo_cli' => 'required|email|max:100',
            'fecha_registro_cli' => 'required|date',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    // Mostrar detalles de un cliente
    public function show($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        return view('clientes.show', compact('cliente'));
    }

    // Mostrar formulario para editar un cliente
    public function edit($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar la información de un cliente
    public function update(Request $request, $cedula_cli)
    {
        $request->validate([
            'nombre_cli' => 'required|max:100',
            'direccion_cli' => 'nullable|max:150',
            'telefono_cli' => 'required|max:10',
            'correo_cli' => 'required|email|max:100',
            'fecha_registro_cli' => 'required|date',
        ]);

        $cliente = Cliente::findOrFail($cedula_cli);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
    }

    // Eliminar un cliente
    public function destroy($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
