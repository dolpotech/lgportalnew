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
        Schema::create('emergency_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments')->onDelete('cascade')->onUpdate('cascade');
            $table->text('title');
            $table->text('address');
            $table->text('phone');
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
        Schema::dropIfExists('emergency_numbers');
    }
};
