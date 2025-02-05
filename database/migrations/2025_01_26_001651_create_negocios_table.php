<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negocios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('celular')->nullable();
            $table->string('celular2')->nullable();
            $table->timestamps();

            // Relación con la tabla negocios
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuarios
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negocios');
    }
};
