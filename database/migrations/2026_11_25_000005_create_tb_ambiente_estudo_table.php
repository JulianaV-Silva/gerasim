<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_ambiente_estudo', function (Blueprint $table) {
            $table->id('id_ambiente');
            $table->unsignedBigInteger('id_usuario');
            $table->string('nm_ambiente', 60);
            $table->text('ds_descricao')->nullable();
            $table->timestamp('dt_criacao')->useCurrent();

            $table->foreign('id_usuario')->references('id_usuario')->on('tb_usuario')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_ambiente_estudo');
    }
};