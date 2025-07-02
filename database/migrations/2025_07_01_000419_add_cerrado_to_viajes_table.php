<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCerradoToViajesTable extends Migration
{
    public function up()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->boolean('cerrado')->default(false)->after('precio');
        });
    }

    public function down()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->dropColumn('cerrado');
        });
    }
}

