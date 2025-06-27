<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rutas', function (Blueprint $table) {
            // Cambiar hora_salida existente a nullable
            $table->time('hora_salida')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('rutas', function (Blueprint $table) {
            // Volver a NOT NULL si hiciera falta
            $table->time('hora_salida')->nullable(false)->change();
        });
    }
};
