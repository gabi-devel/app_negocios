<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model // Sigue el principio "Fat Models, Skinny Controllers". El modelo se encarga de manejar sus propios datos
{
    use HasFactory;

    protected $fillable = ['producto', 'codigo_barra', 'marca', 'precio', 'cantidad', 'disponible', 'negocio_id'];

    // Relación: Un producto pertenece a un negocio
    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public static function crear_o_actualizar_producto($data, $negocioId)
    {
        $producto = self::where('codigo_barra', $data['codigo_barra'])->first();

        if ($producto) {
            // Actualizar precio y sumar cantidad al stock
            $producto->update([
                'precio' => $data['precio'],
                'cantidad' => $producto->cantidad + $data['cantidad'],
            ]);
            return $producto;
        } 

        // Si no existe, crearlo
        return self::create([
            'producto' => $data['producto'],
            'codigo_barra' => $data['codigo_barra'],
            'marca' => $data['marca'],
            'precio' => $data['precio'],
            'cantidad' => $data['cantidad'],
            'disponible' => true,
            'negocio_id' => $negocioId,
        ]);
    }

    public function actualizarProducto($data)
    {
        $this->update([
            'producto' => $data['producto'],
            'codigo_barra' => $data['codigo_barra'],
            'marca' => $data['marca'],
            'precio' => $data['precio'],
            'cantidad' => $data['cantidad'],
            'disponible' => $data['disponible'],
        ]);
    }

}
