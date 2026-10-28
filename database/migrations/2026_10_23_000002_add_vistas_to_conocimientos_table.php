<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cuántas veces se ha consultado cada ficha.
     */
    public function up()
    {
        Schema::table('conocimientos', function (Blueprint $table) {
            $table->unsignedInteger('vistas')->default(0)->after('enlace');
        });
    }

    public function down()
    {
        Schema::table('conocimientos', function (Blueprint $table) {
            $table->dropColumn('vistas');
        });
    }
};
