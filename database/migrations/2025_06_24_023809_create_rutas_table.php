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

            // origen y destino
            $table->string('origen');
            $table->string('destino');

            // hora de salida
            $table->time('hora_salida');

            // precios / recargos / descuentos según tu tabla
            $table->decimal('precio_bus_normal',8,2)->default(0);
            $table->decimal('recargo_bus_doble_piso',8,2)->default(0);
            $table->decimal('recargo_bus_1piso_ac',8,2)->default(0);
            $table->decimal('recargo_semicama',8,2)->default(0);

            $table->decimal('descuento_3ra_edad',8,2)->default(0);
            $table->decimal('precio_cortesia',8,2)->default(0);
            $table->decimal('descuento_discapacidad',8,2)->default(0);
            $table->decimal('descuento_2',8,2)->nullable();
            $table->decimal('descuento_3',8,2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rutas');
    }
}
