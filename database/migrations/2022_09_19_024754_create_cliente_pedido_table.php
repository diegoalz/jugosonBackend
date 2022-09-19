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
        Schema::create('cliente_pedido', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('cantidad')->unsigned();
            $table->boolean('estatus')->default(true);
            $table->timestamps();
            $table->bigInteger('id_pedido')->unsigned();
            $table->bigInteger('id_inventario')->unsigned();
            $table->foreign('id_inventario')->references('id')->on('inventario')->onDelete('cascade');
            $table->foreign('id_pedido')->references('id')->on('pedido')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_pedido');
    }
};
