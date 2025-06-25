<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoferesTable extends Migration
{
    public function up()
    {
        Schema::create('choferes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('bus_codigo', 10);
            $table->string('nombre_chofer');
            $table->string('licencia');
            $table->date('vencimiento_licencia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('choferes');
    }
}
