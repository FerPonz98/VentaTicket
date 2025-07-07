<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->foreignId('turno_id')
                  ->after('cajero_id')
                  ->nullable()
                  ->constrained('turnos')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cargas', function (Blueprint $table) {
            $table->dropForeign(['turno_id']);
            $table->dropColumn('turno_id');
        });
    }
};

