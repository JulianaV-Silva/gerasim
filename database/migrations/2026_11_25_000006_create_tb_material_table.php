<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_material', function (Blueprint $table) {
            $table->id('id_material');
            $table->unsignedBigInteger('id_ambiente');
            $table->string('nm_material', 60);
            $table->text('ds_caminho_arquivo');
            $table->boolean('fl_processamento')->default(false);

            $table->foreign('id_ambiente')->references('id_ambiente')->on('tb_ambiente_estudo')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_material');
    }
};