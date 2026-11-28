<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_tentativa_questao', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tentativa');
            $table->unsignedBigInteger('id_questao');
            $table->boolean('bl_resposta');

            $table->primary(['id_tentativa', 'id_questao']);
            $table->foreign('id_tentativa')->references('id_tentativa')->on('tb_tentativa')->onDelete('cascade');
            $table->foreign('id_questao')->references('id_questao')->on('tb_questoes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_tentativa_questao');
    }
};