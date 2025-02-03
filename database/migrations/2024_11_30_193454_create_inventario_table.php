<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->string('codigo', 20)->primary(); 
            $table->string('nombre_producto', 40)->nullable(); 
            $table->decimal('cantidad_disponible', 10, 2); 
            $table->timestamp('fecha_registro')->useCurrent(); 
            $table->timestamps(); // Esto añade created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
