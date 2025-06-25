<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViajesTable extends Migration
{
    public function up()
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')
                  ->constrained('buses')
                  ->onDelete('cascade');
            $table->foreignId('ruta_id')
                  ->constrained('rutas')
                  ->onDelete('cascade');
            $table->dateTime('fecha_salida');
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viajes');
    }
}
