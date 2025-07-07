<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // DROP AUTO_INCREMENT de la columna CI
        DB::statement("
          ALTER TABLE `choferes`
          MODIFY COLUMN `CI` BIGINT UNSIGNED NOT NULL
        ");
    }

    public function down()
    {
        // volver a añadir AUTO_INCREMENT
        DB::statement("
          ALTER TABLE `choferes`
          MODIFY COLUMN `CI` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
        ");
    }
};
