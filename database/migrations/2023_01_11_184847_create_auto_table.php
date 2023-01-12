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
        Schema::create('auto', function (Blueprint $table) {
            $table->id()->nullable();
            $table->string('mark')->default('');
            $table->string('model')->default('');
            $table->string('generation')->default('');
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedMediumInteger('run')->nullable();
            $table->string('color')->default('');
            $table->string('body-type')->default('');
            $table->string('engine-type')->default('');
            $table->string('transmission')->default('');
            $table->string('gear-type')->default('');
            $table->unsignedInteger('generation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto');
    }
};
