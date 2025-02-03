<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_producto', function (Blueprint $table) {
            $table->string('id_detpro', 20)->primary(); // Clave primaria
            $table->string('tipo_animal_detpro', 50);
            $table->string('tamano_raza_detpro', 20)->nullable(); ;
            $table->decimal('peso_libras_detpro', 8, 2)->nullable(); ;
            $table->decimal('precio_libras_detpro', 10, 2)->nullable(); ;

            // Relación con la tabla productos
            $table->string('codigo_pro', 15); // Llave foránea
            $table->foreign('codigo_pro')->references('codigo_pro')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_producto');
    }
};
