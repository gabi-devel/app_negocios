<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cod_barras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barra')->unique(); // El valor del código de barras
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cod_barras');
    }
};
