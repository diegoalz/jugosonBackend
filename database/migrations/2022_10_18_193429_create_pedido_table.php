<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("orden_compra", 50);
            $table->boolean('estatus')->default(true);
            $table->integer('calificacion')->unsigned()->nullable()->default(0);
            $table->string('proceso'); //Es en que etapa va el pedido (entregado, en camino, en proceso)
            $table->string("bitacora")->nullable();
            $table->timestamp('fecha_pedido')->nullable();
            $table->bigInteger("id_cliente")->unsigned();
            $table->bigInteger("id_usuario")->unsigned();
            $table->foreign('id_cliente')->references('id')->on('cliente')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido');
    }
};
