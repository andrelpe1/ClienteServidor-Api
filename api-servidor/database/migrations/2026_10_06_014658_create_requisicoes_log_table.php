<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requisicoes_log', function (Blueprint $table) {
            $table->id();
            $table->string('metodo', 10);
            $table->string('caminho');
            $table->string('ip', 45);
            $table->json('corpo')->nullable();
            $table->unsignedSmallInteger('status')->nullable();
            $table->json('resposta')->nullable();
            $table->unsignedInteger('duracao_ms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicoes_log');
    }
};
