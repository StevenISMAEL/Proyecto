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
        Schema::create('ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ven')->primary(); // ID único de la venta (hasta 13 dígitos)
            $table->string('cedula_cli', 10)->nullable(); // Relación con clientes
            $table->date('fecha_emision_ven'); // Fecha de emisión de la venta
            $table->string('nombre_cli_ven', 100); // Nombre del cliente
            $table->timestamps(); // created_at y updated_at

            // Relación con clientes
            $table->foreign('cedula_cli')
                ->references('cedula_cli')
                ->on('clientes')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
