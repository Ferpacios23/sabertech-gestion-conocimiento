<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cada fila es una "ficha" de conocimiento: un problema y su solución.
     */
    public function up()
    {
        Schema::create('conocimientos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->text('problema');
            $table->text('solucion');
            $table->string('enlace')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conocimientos');
    }
};
