<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTicketsToPasajes extends Migration
{
    public function up()
    {
        Schema::rename('tickets', 'pasajes');
    }

    public function down()
    {
        Schema::rename('pasajes', 'tickets');
    }
}
