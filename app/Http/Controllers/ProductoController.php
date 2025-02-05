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

    public function obtenerProducto($codigoBarra)
    {
        $producto = Producto::where('codigo_barra', $codigoBarra)->first();

        if ($producto) {
            return response()->json([
                'success' => true,
                'producto' => [
                    'id' => $producto->id,
                    'nombre' => $producto->producto,
                    'precio' => $producto->precio,
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
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
        
        /* $data = $request->validate([
            'producto' => 'nullable|string|max:255',
            'codigo_barra' => 'nullable|string|unique:productos,codigo_barra|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric|min:0',
            'cantidad' => 'nullable|integer|min:0',
            'disponible' => 'boolean',
            'negocio_id' => 'required|exists:negocios,id'
        ]);

        
        // Crear o actualizar el producto en base de datos
        if ($producto) {
            // Si el producto ya existe, actualizar su precio
            $producto->update([
                'precio' => $request->precio,
                'cantidad' => $request->cantidad, 
            ]);
        } else {
            // Si no existe, crearlo
            Producto::create($data); 
        } */

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
            'producto' => 'nullable|string|max:255',
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
}
