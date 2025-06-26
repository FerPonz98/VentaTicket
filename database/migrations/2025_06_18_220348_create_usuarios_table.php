<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('ci_usuario', 20)->primary();
            $table->string('nombre_usuario', 50)->unique();
            $table->string('contrasena', 255);
            $table->string('foto', 255)->nullable();
            $table->string('nombre', 50)->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->enum('sexo', ['M', 'F', 'Otro'])->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->nullable();
            $table->string('estado_civil', 20)->nullable();
            $table->string('lugar_residencia', 100)->nullable();
            $table->string('domicilio', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('celular', 45)->nullable();
            $table->text('referencias')->nullable();
            $table->enum('rol', [
                'admin',
                'supervisor gral',
                'supervisor suc',
                'cajero',
                'chofer y ayudante',
                'carga',
                'ventas qr',
                'encomienda'       
            ])->nullable();
            $table->string('sucursal', 255)->nullable();
            $table->string('security_question', 255)->nullable();
            $table->string('security_answer', 255)->nullable();
            $table->string('documento_1', 255)->nullable();
            $table->string('documento_2', 255)->nullable();
            $table->string('documento_3', 255)->nullable();
            $table->string('documento_4', 255)->nullable();
            $table->string('documento_5', 255)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
