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
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_falla')
            ->Nullable()
            ->constrained('fallas')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_user')
            ->Nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignId('id_strabajos')
            ->Nullable()
            ->constrained('strabajos')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('des_trabajo')->Nullable();
            $table->string('foto_trabajo')->Nullable();
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
        Schema::dropIfExists('trabajos');
    }
};
