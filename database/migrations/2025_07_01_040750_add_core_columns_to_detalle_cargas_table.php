<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('detalle_cargas', function (Blueprint $table) {
           
            $table->foreignId('carga_id')
                  ->after('id')
                  ->constrained('cargas')
                  ->onDelete('cascade');

            $table->integer('cantidad')->after('carga_id');
            $table->string('descripcion')->after('cantidad');
            $table->decimal('peso', 8, 2)->after('descripcion');
        });
    }

    public function down()
    {
        Schema::table('detalle_cargas', function (Blueprint $table) {
            $table->dropForeign(['carga_id']);
            $table->dropColumn(['carga_id', 'cantidad', 'descripcion', 'peso']);
        });
    }
};

