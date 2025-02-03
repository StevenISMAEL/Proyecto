<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('codigo_pro', 15)->primary();
            $table->string('nombre_pro', 50);
            $table->string('descripcion_pro', 100);
            $table->boolean('alimenticio_pro');
            $table->decimal('precio_unitario_pro', 10, 2);
            $table->timestamps(); // Uso de los timestamps de Laravel (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
