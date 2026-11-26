<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_simulado_topico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_simulado');
            $table->unsignedBigInteger('id_topico');

            $table->primary(['id_simulado', 'id_topico']);
            $table->foreign('id_simulado')->references('id_simulado')->on('tb_simulado')->onDelete('cascade');
            $table->foreign('id_topico')->references('id_topico')->on('tb_topico')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_simulado_topico');
    }
};