<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();
            $table->string('estado')->nullable();
            $table->string('remitente_nombre')->nullable();
            $table->string('remitente_ci')->nullable();
            $table->string('remitente_telefono')->nullable();
            $table->string('nro_guia')->nullable();
            $table->string('cajero_id')->nullable();
            $table->date('fecha')->nullable();
            $table->time('horario')->nullable();
            $table->time('hora_recepcion')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropColumn([
                'origen',
                'destino',
                'estado',
                'remitente_nombre',
                'remitente_ci',
                'remitente_telefono',
                'nro_guia',
                'cajero_id',
                'fecha',
                'horario',
                'hora_recepcion',
            ]);
        });
    }
    
};
