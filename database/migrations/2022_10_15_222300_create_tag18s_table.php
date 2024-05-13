<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag18s', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->string('descripcion');
            $table->string('operacion');
            $table->string('ubicacion');

            $table->foreignId('id_cen')
            ->Nullable()
            ->constrained('centros')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_planta')
            ->Nullable()
            ->constrained('plantas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_seccion')
            ->Nullable()
            ->constrained('seccions')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_categoria')
            ->Nullable()
            ->constrained('categorias')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_status')
            ->Nullable()
            ->constrained('stags')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag18s');
    }
};
