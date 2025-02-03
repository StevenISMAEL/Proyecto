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
        Schema::create('compras', function (Blueprint $table) {
            $table->string('id_com', 15)->primary(); // ID único de la compra
            $table->string('nombre_proveedor_com', 100); // Nombre del proveedor para histórico
            $table->string('ruc_pro', 13)->nullable(); // RUC del proveedor (relación)
            $table->date('fecha_emision_com'); // Fecha de emisión de la compra
            $table->timestamps(); // created_at y updated_at

            // Relación con proveedores
            $table->foreign('ruc_pro')->references('ruc')->on('proveedores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
