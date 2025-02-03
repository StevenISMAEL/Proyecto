<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID principal auto-incremental
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->timestamp('email_verified_at')->nullable(); // Verificación del correo
            $table->string('password'); // Contraseña encriptada
            $table->rememberToken(); // Token para recordar sesión
            $table->timestamps(); // Campos created_at y updated_at
            $table->string('role')->default('user'); // Rol del usuario, valor por defecto: user
            $table->string('profile_photo')->nullable(); // Foto de perfil (opcional)
            $table->string('phone', 15)->nullable(); // Número de teléfono (opcional)
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Correo como clave primaria
            $table->string('token'); // Token de restablecimiento de contraseña
            $table->timestamp('created_at')->nullable(); // Fecha de creación del token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión
            $table->foreignId('user_id')->nullable()->index(); // Relación con el usuario
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario
            $table->text('user_agent')->nullable(); // Información del navegador o cliente
            $table->longText('payload'); // Datos de la sesión
            $table->integer('last_activity')->index(); // Última actividad registrada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions'); // Elimina la tabla de sesiones
        Schema::dropIfExists('password_reset_tokens'); // Elimina la tabla de tokens de restablecimiento
        Schema::dropIfExists('users'); // Elimina la tabla de usuarios
    }
};
