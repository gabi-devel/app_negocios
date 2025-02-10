<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('productos', function (Blueprint $table) {
        // Eliminar el índice único existente en codigo_barra
        $table->dropUnique(['codigo_barra']); // o usar el nombre: $table->dropUnique('productos_codigo_barra_unique');
        
        // Agregar el índice único compuesto
        $table->unique(['negocio_id', 'codigo_barra']);
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        // Eliminar el índice compuesto
        $table->dropUnique(['negocio_id', 'codigo_barra']);
        
        // Volver a agregar el índice único original en codigo_barra
        $table->unique('codigo_barra');
    });
}
};
