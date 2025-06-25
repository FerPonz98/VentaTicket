<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->unsignedBigInteger('chofer_id')->nullable()->after('modelo');
            $table->foreign('chofer_id')->references('id')->on('choferes')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropForeign(['chofer_id']);
            $table->dropColumn('chofer_id');
        });
    }   

};
