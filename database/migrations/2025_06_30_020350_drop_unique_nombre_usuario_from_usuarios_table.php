<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueNombreUsuarioFromUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
     
            $table->dropUnique(['nombre_usuario']);
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unique('nombre_usuario');
        });
    }
}
