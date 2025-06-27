<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruta_id')
                  ->constrained('rutas')
                  ->cascadeOnDelete();
            $table->foreignId('origen_id')
                  ->constrained('stops')
                  ->cascadeOnDelete();
            $table->foreignId('destino_id')
                  ->constrained('stops')
                  ->cascadeOnDelete();
            $table->string('tipo_pasajero', 50);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
