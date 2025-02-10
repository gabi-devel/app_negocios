<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Negocio;
use Illuminate\Http\Request;
/* use App\Models\User; */

class ProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $negocio = Negocio::crearNegocio($user);

        // Obtener los productos del negocio
        $productos = Producto::where('negocio_id', $negocio->id)->get();

        return view('productos.listar', compact('productos'));
    }

    public function buscarProducto($codigo)
    {
        $negocio_id = auth()->user()->negocio->id;
        
        $producto = Producto::where('codigo_barra', $codigo)
            ->where('negocio_id', $negocio_id) // Filtra por el negocio del usuario
            ->first();

        if (!$producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }
    
        return response()->json([
            'success' => true,
            'producto' => [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'marca' => $producto->marca,
                'precio' => $producto->precio,
                /* 'cantidad' => $producto->cantidad, */
            ]
        ]);
    }

        

    public function confirmarCompra(Request $request)
    {
        $productos = $request->input('productos');

        if (empty($productos)) {
            return response()->json(['success' => false, 'message' => 'No hay productos']);
        }

        // Registrar la compra
        $compra = Compra::create(['user_id' => auth()->id()]);

        foreach ($productos as $producto) {
            DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto['id'],
                'precio' => $producto['precio'],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Compra registrada con éxito']);
    }

    public function create()
    {
        return view('productos.agregar');
    }

    public function store(Request $request)
    {
        $user = auth()->user();  
        $data = $request->all();

        $negocio = Negocio::crearNegocio($user);

        Producto::crear_o_actualizar_producto($data, $negocio->id);

        return redirect()->back()->with('success', 'Producto agregado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    public function edit(Producto $producto)
    {
        return view('productos.editar', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'codigo_barra' => 'nullable|string|max:255|unique:productos,codigo_barra,' . $producto->id,
            'marca' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric|min:0',
            'cantidad' => 'nullable|integer|min:0',
            'disponible' => 'nullable|boolean',
        ]);

        $producto->actualizarProducto($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->back()->with('success', 'Producto eliminado correctamente.');
    }

    public function buscarPorCodigo($codigo)
    {
        $negocioId = auth()->user()->negocio->id; // Asegúrate de que el usuario tenga negocio

        $producto = Producto::where('negocio_id', $negocioId)
                            ->where('codigo_barra', $codigo)
                            ->first();

        if ($producto) {
            return response()->json([
                'success' => true,
                'producto' => $producto,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Producto no encontrado',
        ], 404);
    }


}
