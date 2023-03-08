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
        Schema::create('resource_maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments');
            $table->text('language')->nullable();
            $table->text('title')->nullable();
            $table->text('body')->nullable();
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
        Schema::dropIfExists('resource_maps');
    }
};
