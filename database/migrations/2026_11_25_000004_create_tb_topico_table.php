<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_topico', function (Blueprint $table) {
            $table->id('id_topico');
            $table->string('nm_topico', 100)->unique();
            $table->text('ds_descricao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_topico');
    }
};