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
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->string('id_detcom', 15)->primary(); // ID único del detalle de compra
            $table->string('nombre_producto_detcom', 100); // Nombre del producto
            $table->string('id_com', 15)->nullable(); // Relación con la tabla compras
            $table->integer('cantidad_pro_detcom'); // Cantidad comprada
            $table->decimal('precio_unitario_detcom', 10, 2); // Precio unitario
            $table->decimal('iva_detcom', 10, 2); // IVA del producto
            $table->timestamps(); // created_at y updated_at

            // Relación con compras
            $table->foreign('id_com')->references('id_com')->on('compras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_compras');
    }
};
