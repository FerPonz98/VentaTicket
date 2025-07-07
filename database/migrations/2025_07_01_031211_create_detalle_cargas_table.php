// database/migrations/xxxx_xx_xx_create_detalle_cargas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleCargasTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_cargas', function (Blueprint $table) {
            $table->id();

            // Relación a la guía de carga
            $table->foreignId('carga_id')
                  ->constrained('cargas')
                  ->onDelete('cascade');

            // Detalle de ítems
            $table->integer('cantidad');    // CANTIDAD *
            $table->string('descripcion');  // DESCRIPCIÓN *
            $table->decimal('peso', 8, 2);  // PESO (KG)

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_cargas');
    }
}
