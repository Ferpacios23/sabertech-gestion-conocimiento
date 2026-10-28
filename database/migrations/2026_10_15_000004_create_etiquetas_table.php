<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Etiquetas libres (palabras clave) y su relación muchos a muchos con las fichas.
     */
    public function up()
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 40)->unique();
            $table->timestamps();
        });

        Schema::create('conocimiento_etiqueta', function (Blueprint $table) {
            $table->foreignId('conocimiento_id')->constrained('conocimientos')->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete();
            $table->primary(['conocimiento_id', 'etiqueta_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conocimiento_etiqueta');
        Schema::dropIfExists('etiquetas');
    }
};
