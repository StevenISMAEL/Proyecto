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
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->string('id_detven', 15)->primary(); // ID único del detalle de venta, como string de hasta 15 caracteres
            $table->string('codigo_pro', 15)->nullable(); // Relación con productos
            $table->unsignedBigInteger('id_ven'); // Relación con la tabla ventas
            $table->string('nombre_producto_detven', 255); // Nombre del producto
            $table->integer('cantidad_pro_detven'); // Cantidad vendida
            $table->decimal('precio_unitario_detven', 10, 2); // Precio unitario
            $table->decimal('precio_libras_detven', 10, 2)->nullable(); // Precio por libra
            $table->decimal('iva_detven', 5, 2); // IVA del producto
            $table->timestamps(); // created_at y updated_at

            // Relación con productos
            $table->foreign('codigo_pro')
                ->references('codigo_pro')
                ->on('productos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
                
            // Relación con ventas
            $table->foreign('id_ven')
                ->references('id_ven')
                ->on('ventas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_ventas');
    }
};
