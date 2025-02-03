<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detalles_compras', function (Blueprint $table) {
            // Agregar la columna 'codigo_pro' que será una clave foránea
            $table->string('codigo_pro', 15)->nullable();  // La columna puede ser nullable si no es obligatorio en algunos casos

            // Definir la clave foránea
            $table->foreign('codigo_pro')->references('codigo_pro')->on('productos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('detalles_compras', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['codigo_pro']);
            $table->dropColumn('codigo_pro');
        });
    }
};
