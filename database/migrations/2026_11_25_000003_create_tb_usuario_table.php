<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nm_usuario', 60)->unique();
            $table->string('nm_email', 60)->unique();
            $table->string('pwd_senha', 40);
            $table->timestamp('dt_cadastro')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_usuario');
    }
};