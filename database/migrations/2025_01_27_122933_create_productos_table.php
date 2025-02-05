<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('producto')->nullable();
            $table->string('codigo_barra')->unique()->nullable();
            $table->string('marca')->nullable();
            $table->decimal('precio', 10, 2)->default(0); // 10 dígitos, 2 decimales
            $table->integer('cantidad')->nullable(); // si está en cero podría figurarles que deben reponer ese producto
            $table->boolean('disponible')->nullable()->default(true); // True = visible (para invisibilizarlo o no de alguna lista, en lugar de eliminar el producto)
            $table->timestamps(); 

            $table->foreignId('negocio_id')->constrained()->onDelete('cascade'); // Relación con negocios
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
