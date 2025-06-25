<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteStopTable extends Migration
{
    public function up()
    {
        Schema::create('route_stop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruta_id')->constrained('rutas')->onDelete('cascade');
            $table->foreignId('stop_id')->constrained('stops')->onDelete('cascade');
            $table->unsignedInteger('sequence');
            $table->time('departure_time')->nullable();
            $table->decimal('precio_bus_normal',           8,2);
            $table->decimal('precio_bus_doble_semicama',   8,2);
            $table->decimal('precio_bus_un_piso_semicama', 8,2);
            $table->decimal('precio_3ra_edad',             8,2);
            $table->decimal('precio_cortesia',             8,2);
            $table->decimal('precio_discapacidad',         8,2);
            $table->decimal('descuento2',                  5,2)->default(0);
            $table->decimal('descuento3',                  5,2)->default(0);
            $table->timestamps();
            $table->unique(['ruta_id','stop_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('route_stop');
    }
}
