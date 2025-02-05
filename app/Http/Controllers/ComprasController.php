<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Crear la compra
        $compra = CompraTotal::create([
            'user_id' => auth()->id(),
        ]);

        // Guardar los productos
        foreach ($validated['productos'] as $producto) {
            CompraProducto::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto['id'],
                'precio' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
            ]);
        }

        return response()->json(['message' => 'Compra registrada exitosamente.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Compras $compras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compras $compras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compras $compras)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compras $compras)
    {
        //
    }
}
