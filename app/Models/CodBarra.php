<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodBarra extends Model
{
    use HasFactory;
    
    protected $table = 'cod_barras';

    protected $fillable = ['codigo_barra'];

    public $timestamps = false;
}
