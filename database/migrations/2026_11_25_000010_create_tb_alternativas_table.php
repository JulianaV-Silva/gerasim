<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_alternativas', function (Blueprint $table) {
            $table->id('id_alternativa');
            $table->unsignedBigInteger('id_questao');
            $table->text('ds_alternativa');
            $table->boolean('fl_correta')->default(false);

            $table->foreign('id_questao')->references('id_questao')->on('tb_questoes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_alternativas');
    }
};