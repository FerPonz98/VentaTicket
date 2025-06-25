<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();

            $table->string('codigo')->unique();
            $table->string('tipo_de_bus');                // 'Un piso' o 'Doble piso'
            $table->boolean('aire_acondicionado')->default(false);

            $table->integer('asientos_piso1')->default(0);
            $table->integer('asientos_piso2')->default(0);

            $table->string('tipo_asiento', 20);

            $table->boolean('tv')->default(false);
            $table->boolean('bano')->default(false);
            $table->boolean('carga_telefono')->default(false);

            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->string('propietario')->nullable();

            $table->boolean('soat')->default(false);
            $table->string('codigo_soat')->nullable();
            $table->date('soat_vencimiento')->nullable();
            $table->boolean('rev_tecnica')->default(false);
            $table->date('rev_tecnica_vencimiento')->nullable();

            $table->date('tarjeta_operacion_vencimiento')->nullable();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('buses');
    }
}
