<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos_turno', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turno_id')->constrained()->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained()->onDelete('cascade');
            $table->enum('tipo_movimiento', ['planilla', 'fotocopia', 'pago_recibo_qr', 'pago_pendiente', 'pago_en_destino']);
            $table->text('descripcion');
            $table->decimal('monto', 10, 2);
            $table->boolean('es_pago_pendiente')->default(false);
            $table->string('sucursal_origen', 50)->nullable();
            $table->string('pago_en_destino', 50)->nullable();
            $table->boolean('sincronizado')->default(false);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('movimientos_turno');
    }
    
};
