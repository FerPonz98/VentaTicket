<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            // Campos del remitente
            $table->string('remitente_nombre')->after('remitente_id')->nullable();
            $table->string('remitente_telefono')->after('remitente_nombre')->nullable();

            
        });
    }

    public function down()
    {
        Schema::table('encomiendas', function (Blueprint $table) {
            $table->dropColumn([
                'remitente_nombre',
                'remitente_telefono',

            ]);
        });
    }
};
