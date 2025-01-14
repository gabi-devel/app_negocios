<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CodBarra;

class CodBarrasController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'codigo_barra' => 'required|string|unique:codBarra,codigo_barra|max:255', // Cambiar 'barcode' por 'codBarra'
        ]);
    
        $codBarra = CodBarra::create([
            'codigo_barra' => $validated['codigo_barra'], // Cambiar 'codigo_barra' por 'codBarra'
        ]);
    
        return response()->json(['message' => 'Código guardado correctamente.']);
    }

}
