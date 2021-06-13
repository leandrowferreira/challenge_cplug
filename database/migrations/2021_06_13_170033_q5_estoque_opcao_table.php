<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Q5EstoqueOpcaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q5_estoque_opcao', function (Blueprint $table) {
            $table->id();

            $table->foreignId('estoque_id');
            $table->foreignId('opcao_id');

            $table->timestamps();

            $table->foreign('estoque_id')->references('id')->on('q5_estoques')->onDelete('cascade');
            $table->foreign('opcao_id')->references('id')->on('q5_opcoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('q5_estoque_opcao');
    }
}
