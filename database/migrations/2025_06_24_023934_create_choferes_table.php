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
            $table->foreignId('bus_id')
                  ->constrained('buses')
                  ->onDelete('cascade');
            $table->string('nombre_chofer');
            $table->string('licencia');
            $table->date('vencimiento_licencia');
            $table->string('nombre_ayudante')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('choferes');
    }
}
