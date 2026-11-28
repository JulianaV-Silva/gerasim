<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('tb_tentativa', function (Blueprint $table) {
            $table->id('id_tentativa');
            $table->unsignedBigInteger('id_simulado');
            $table->dateTime('dt_inicio');
            $table->dateTime('dt_fim');
            $table->integer('qt_acertos');
            $table->integer('qt_erros');

            $table->foreign('id_simulado')->references('id_simulado')->on('tb_simulado')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_tentativa');
    }
};