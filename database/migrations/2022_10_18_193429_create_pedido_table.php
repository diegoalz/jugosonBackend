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
            $table->string('orden_compra', 50);
            $table->string('direccion', 100);
            $table->boolean('estatus')->default(true);
            $table->string('proceso')->default("Iniciado"); //Es en que etapa va el pedido (entregado, en camino, en proceso)
            $table->timestamps();
            $table->bigInteger('id_cliente')->unsigned()->nullable();
            $table->bigInteger('id_usuario')->unsigned()->nullable();
            // $table->integer('calificacion')->unsigned()->default(0);
            // $table->string('bitacora')->nullable()->default("Iniciada");
            // $table->foreign('cliente')->references('id')->on('cliente')->onDelete('cascade');
            // $table->foreign('usuario')->references('id')->on('users')->onDelete('cascade');
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
