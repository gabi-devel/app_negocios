<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NegocioController extends Controller
{
    public function crearNegocioSiNoExiste()
    {
        $user = Auth::user();

        // Si el usuario ya tiene negocio, devolverlo
        if ($user->negocio) {
            return $user->negocio;
        }

        // Crear negocio si no existe
        $negocio = Negocio::create([
            'user_id' => $user->id,
            'nombre' => $user->name,
        ]);

        return $negocio;
    }
}
