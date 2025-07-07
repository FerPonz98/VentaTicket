<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLayoutPisosToBusesTable extends Migration
{
    public function up()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->json('layout_piso1')->nullable()->after('asientos_piso2');
            $table->json('layout_piso2')->nullable()->after('layout_piso1');
        });
    }

    public function down()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn(['layout_piso1', 'layout_piso2']);
        });
    }
}
