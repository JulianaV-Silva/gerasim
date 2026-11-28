<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_questoes', function (Blueprint $table) {
            $table->id('id_questao');
            $table->unsignedBigInteger('id_simulado');
            $table->text('ds_enunciado');
            $table->unsignedBigInteger('id_topico');
            $table->integer('nu_peso');

            $table->foreign('id_simulado')->references('id_simulado')->on('tb_simulado')->onDelete('cascade');
            $table->foreign('id_topico')->references('id_topico')->on('tb_topico')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_questoes');
    }
};