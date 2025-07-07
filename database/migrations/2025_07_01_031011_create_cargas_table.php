<?php

// database/migrations/xxxx_xx_xx_create_cargas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargasTable extends Migration
{
    public function up()
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();
            
            // Relación al cajero (usuario)
            $table->foreignId('cajero_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Cabecera de la guía
            $table->string('nro_guia')->unique();            // NRO DE GUÍA DE CARGA
            $table->enum('estado', ['pagado','por pagar']);  // ESTADO
            $table->string('origen');
            $table->string('destino');

            // Datos del remitente
            $table->string('remitente_nombre');
            $table->string('remitente_ci');
            $table->string('remitente_telefono');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargas');
    }
}

