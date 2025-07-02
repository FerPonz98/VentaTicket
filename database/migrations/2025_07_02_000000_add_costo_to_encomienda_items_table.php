<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds the 'costo' column to the encomienda_items table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encomienda_items', function (Blueprint $table) {
            $table->decimal('costo', 10, 2)
                  ->after('peso')
                  ->default(0)
                  ->comment('Costo en moneda local por ítem');
        });
    }

    /**
     * Reverse the migrations.
     * Removes the 'costo' column.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encomienda_items', function (Blueprint $table) {
            $table->dropColumn('costo');
        });
    }
};
