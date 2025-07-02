<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsCargaToEncomiendas extends Migration
{
    public function up()
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->boolean('es_carga')
                  ->default(false)
                  ->after('estado')
                  ->comment('0=encomienda,1=carga');
        });
    }

    public function down()
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->dropColumn('es_carga');
        });
    }
}
