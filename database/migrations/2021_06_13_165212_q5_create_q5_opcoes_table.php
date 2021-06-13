<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Q5CreateQ5OpcoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q5_opcoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atributo_id');

            $table->string('valor', 200);

            $table->timestamps();

            $table->foreign('atributo_id')->references('id')->on('q5_atributos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('q5_opcoes');
    }
}
