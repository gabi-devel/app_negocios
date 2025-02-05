<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index($negocio_id)
    {
        /* 
        Si el usuario tiene más de un negocio, puedes obtener uno en específico seleccionándolo por su ID:
        $negocio = auth()->user()->negocios()->find($negocio_id);

        if (!$negocio) {
            abort(403, 'No tienes acceso a este negocio');
        }

        $productos = $negocio->stock;

        return view('stock.index', compact('productos'));
        
        */
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
