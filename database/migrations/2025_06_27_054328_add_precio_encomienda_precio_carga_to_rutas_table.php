<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rutas', function (Blueprint $table) {
            // Agregar precios de encomienda y carga a la tabla rutas
            $table->decimal('precio_encomienda', 10, 2)
                  ->after('descuento_3')
                  ->default(0);
            $table->decimal('precio_carga', 10, 2)
                  ->after('precio_encomienda')
                  ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropColumn(['precio_encomienda', 'precio_carga']);
        });
    }
};
