<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
        
            if (!Schema::hasColumn('tickets', 'viaje_id')) {
                $table->foreignId('viaje_id')
                      ->after('id')
                      ->constrained('viajes')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('tickets', 'origen')) {
                $table->string('origen')->after('viaje_id');
            }
            if (!Schema::hasColumn('tickets', 'destino')) {
                $table->string('destino')->after('origen');
            }
            if (!Schema::hasColumn('tickets', 'nombre_completo')) {
                $table->string('nombre_completo')->after('destino');
            }
            if (!Schema::hasColumn('tickets', 'tipo_pasajero')) {
                $table->enum('tipo_pasajero', ['adulto','tercera_edad','menor','cortesia','desc'])
                      ->default('adulto')
                      ->after('nombre_completo');
            }
            if (!Schema::hasColumn('tickets', 'tercera_edad')) {
                $table->boolean('tercera_edad')->default(false)->after('tipo_pasajero');
            }
            if (!Schema::hasColumn('tickets', 'menor_edad')) {
                $table->boolean('menor_edad')->default(false)->after('tercera_edad');
            }
            if (!Schema::hasColumn('tickets', 'fecha')) {
                $table->date('fecha')->nullable()->after('menor_edad');
            }
            if (!Schema::hasColumn('tickets', 'asiento')) {
                $table->string('asiento')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('tickets', 'tipo_asiento')) {
                $table->string('tipo_asiento')->nullable()->after('asiento');
            }

            if (!Schema::hasColumn('tickets', 'precio')) {
                $table->decimal('precio', 8, 2)->after('tipo_asiento');
            }
            if (!Schema::hasColumn('tickets', 'forma_pago')) {
                $table->enum('forma_pago', ['efectivo','tarjeta','qr','pago_destino'])
                      ->default('efectivo')
                      ->after('precio');
            }

            if (!Schema::hasColumn('tickets', 'hora_en_oficina')) {
                $table->time('hora_en_oficina')->nullable()->after('forma_pago');
            }
            if (!Schema::hasColumn('tickets', 'cajero_id')) {
                $table->unsignedBigInteger('cajero_id')->nullable()->after('hora_en_oficina');
                $table->foreign('cajero_id')
                      ->references('ci_usuario')
                      ->on('usuarios')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {

            if (Schema::hasColumn('tickets', 'cajero_id')) {
                $table->dropForeign(['cajero_id']);
                $table->dropColumn('cajero_id');
            }
            if (Schema::hasColumn('tickets', 'hora_en_oficina')) {
                $table->dropColumn('hora_en_oficina');
            }
            if (Schema::hasColumn('tickets', 'forma_pago')) {
                $table->dropColumn('forma_pago');
            }
            if (Schema::hasColumn('tickets', 'precio')) {
                $table->dropColumn('precio');
            }
            if (Schema::hasColumn('tickets', 'tipo_asiento')) {
                $table->dropColumn('tipo_asiento');
            }
            if (Schema::hasColumn('tickets', 'asiento')) {
                $table->dropColumn('asiento');
            }
            if (Schema::hasColumn('tickets', 'fecha')) {
                $table->dropColumn('fecha');
            }
            if (Schema::hasColumn('tickets', 'menor_edad')) {
                $table->dropColumn('menor_edad');
            }
            if (Schema::hasColumn('tickets', 'tercera_edad')) {
                $table->dropColumn('tercera_edad');
            }
            if (Schema::hasColumn('tickets', 'tipo_pasajero')) {
                $table->dropColumn('tipo_pasajero');
            }
            if (Schema::hasColumn('tickets', 'nombre_completo')) {
                $table->dropColumn('nombre_completo');
            }
            if (Schema::hasColumn('tickets', 'destino')) {
                $table->dropColumn('destino');
            }
            if (Schema::hasColumn('tickets', 'origen')) {
                $table->dropColumn('origen');
            }
            if (Schema::hasColumn('tickets', 'viaje_id')) {
                $table->dropForeign(['viaje_id']);
                $table->dropColumn('viaje_id');
            }
        });
    }
}
