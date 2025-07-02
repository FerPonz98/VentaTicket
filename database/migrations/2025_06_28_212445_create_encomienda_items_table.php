<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncomiendaItemsTable extends Migration
{
    public function up()
    {
        Schema::create('encomienda_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encomienda_id')
                  ->constrained('encomiendas')
                  ->cascadeOnDelete();
            $table->integer('cantidad');
            $table->string('descripcion');
            $table->decimal('peso', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('encomienda_items');
    }
}
