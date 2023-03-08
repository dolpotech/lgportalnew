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
        Schema::create('elected_officials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments');
            $table->string('language')->nullable();
            $table->text('title')->nullable();
            $table->longText('body')->nullable();
            $table->text('designation')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('photo')->nullable();
            $table->longText('post_box')->nullable();
            $table->longText('section')->nullable();
            $table->longText('tenure')->nullable();
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
        Schema::dropIfExists('elected_officials');
    }
};
