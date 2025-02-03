<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->string('id_kar', 20)->primary();
            $table->string('codigo_pro', 15)->nullable();
            $table->integer('stock_kar')->unsigned();
            $table->integer('minimo_kar')->unsigned();
            $table->integer('maximo_kar')->unsigned();
            $table->timestamps();

            // Relación con la tabla productos
            $table->foreign('codigo_pro')
                ->references('codigo_pro')
                ->on('productos')
                ->onDelete('cascade') // Puedes cambiar a 'cascade' si prefieres eliminar el kardex cuando se elimina el producto
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
