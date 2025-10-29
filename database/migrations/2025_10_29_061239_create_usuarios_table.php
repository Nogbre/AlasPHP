<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('direccion_domiciliaria')->nullable();
            $table->string('correo_electronico')->unique();
            $table->string('contrasena');
            $table->string('telefono')->nullable();
            $table->string('ci')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('rol')->default('usuario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
