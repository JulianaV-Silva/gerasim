<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_simulado', function (Blueprint $table) {
            $table->id('id_simulado');
            $table->unsignedBigInteger('id_ambiente');
            $table->string('nm_simulado', 100);
            $table->integer('qtd_questoes');
            $table->timestamp('dt_criacao')->useCurrent();

            $table->foreign('id_ambiente')->references('id_ambiente')->on('tb_ambiente_estudo')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_simulado');
    }
};