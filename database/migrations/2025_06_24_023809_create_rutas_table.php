<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->string('origen', 50);
            $table->string('destino', 50);
            $table->time('hora_salida');
            $table->decimal('precio_base', 10, 2)->default(0);
            $table->decimal('precio_bus_doble_semicama', 10, 2)->default(0);
            $table->decimal('precio_bus_un_piso_semicama', 10, 2)->default(0);
            $table->decimal('precio_3ra_edad', 10, 2)->default(0);
            $table->decimal('precio_cortesia', 10, 2)->default(0);
            $table->decimal('precio_discapacidad', 10, 2)->default(0);
            $table->decimal('descuento2', 10, 2)->default(0);
            $table->decimal('descuento3', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rutas');
    }
}
