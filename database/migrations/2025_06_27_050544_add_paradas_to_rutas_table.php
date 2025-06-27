<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rutas', function (Blueprint $table) {
            // JSON nullable sin valor por defecto, MySQL no admite DEFAULT en JSON
            $table->json('paradas')
                  ->nullable()
                  ->after('descuento_3');
        });
    }

    public function down()
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropColumn('paradas');
        });
    }
};
