<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'direccion', 'celular', 'celular2', 'user_id'];

    // Relación con User (un negocio pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Stock (un negocio tiene muchos productos)
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public static function crearNegocio($user) 
    { 
        return self::firstOrCreate(
            ['user_id' => $user->id], // Condición de búsqueda
            ['nombre' => $user->name] // Valores a insertar si no existe
        );
    }
}
