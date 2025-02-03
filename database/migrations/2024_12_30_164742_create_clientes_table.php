<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClientesTable extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('cedula_cli', 10)->primary(); // Cedula como clave primaria
            $table->string('nombre_cli', 100); // Nombre del cliente
            $table->string('direccion_cli', 150)->nullable(); // Dirección del cliente
            $table->string('telefono_cli', 10); // Teléfono del cliente
            $table->string('correo_cli', 100); // Correo del cliente
            $table->date('fecha_registro_cli'); // Fecha de registro del cliente
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
