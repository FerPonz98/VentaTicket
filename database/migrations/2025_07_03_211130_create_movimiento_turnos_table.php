<?php
// database/migrations/2025_07_03_000001_create_movimiento_turnos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimiento_turnos', function (Blueprint $table) {
            $table->id(); 

            $table->unsignedBigInteger('turno_id'); 
            $table->unsignedSmallInteger('sucursal_id'); 
            $table->enum('tipo_movimiento', [
                'planilla', 
                'fotocopia', 
                'pago_recibo_qr', 
                'pago_pendiente', 
                'pago_en_destino'
            ]); 
            $table->text('descripcion'); 
            $table->decimal('monto', 10, 2);
            $table->boolean('es_pago_pendiente')->default(false); 
            $table->string('sucursal_origen', 50)->nullable(); 
            $table->string('pago_en_destino', 50)->nullable(); 
            $table->boolean('sincronizado')->default(false); 
            $table->timestamps();  
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimiento_turnos');
    }
};

