<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Producto;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kardex = Kardex::with('producto')->paginate(10);
        return view('kardex.index', compact('kardex'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('kardex.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kar' => 'required|string|max:20|unique:kardex,id_kar',
            'codigo_pro' => 'nullable|exists:productos,codigo_pro',
            'stock_kar' => 'required|integer|min:0',
            'minimo_kar' => 'required|integer|min:0',
            'maximo_kar' => 'required|integer|min:0|gte:minimo_kar',
        ]);

        Kardex::create($request->all());
        return redirect()->route('kardex.index')->with('success', 'Kardex creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kardex $kardex)
    {
        return view('kardex.show', compact('kardex'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kardex $kardex)
    {
        $productos = Producto::all();
        return view('kardex.edit', compact('kardex', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kardex $kardex)
    {
        $request->validate([
            'codigo_pro' => 'nullable|exists:productos,codigo_pro',
            'stock_kar' => 'required|integer|min:0',
            'minimo_kar' => 'required|integer|min:0',
            'maximo_kar' => 'required|integer|min:0|gte:minimo_kar',
        ]);

        $kardex->update($request->all());
        return redirect()->route('kardex.index')->with('success', 'Kardex actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kardex $kardex)
    {
        $kardex->delete();
        return redirect()->route('kardex.index')->with('success', 'Kardex eliminado correctamente.');
    }
}
