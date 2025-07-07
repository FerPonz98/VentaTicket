<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexTable extends Migration
{
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();  
            $table->string('chofer_id');  
            $table->string('producto_nombre');  

            $table->timestamps();  
            $table->foreign('chofer_id')->references('CI')->on('choferes')->onDelete('cascade');  
        });
    }

    public function down()
    {
        Schema::dropIfExists('kardex');
    }
}

