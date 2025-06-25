<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (!Schema::hasColumn('usuarios', 'security_question')) {
            $table->string('security_question')->nullable();
            }

            if (!Schema::hasColumn('usuarios', 'security_answer')) {
              $table->string('security_answer')->nullable();
           }
      });
    }


    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['security_question', 'security_answer']);
     });
    }

};
