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
        Schema::create('fallas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tag18s')
            ->Nullable()
            ->constrained('tag18s')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_usuario')
            ->Nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_sfallas')
            ->Nullable()
            ->constrained('sfallas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('descripcion_falla')->Nullable();
            $table->string('turno')->Nullable();
            $table->string('foto_falla')->Nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fallas');
    }
};
