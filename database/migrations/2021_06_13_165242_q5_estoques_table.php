<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Q5EstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q5_estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id');

            $table->decimal('preco', 10, 2);
            $table->unsignedMediumInteger('quantidade')->default(0);

            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('q5_produtos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('q5_estoques');
    }
}
