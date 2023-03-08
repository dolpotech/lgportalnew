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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments');
            $table->string('language')->nullable();
            $table->text('title')->nullable();
            $table->text('phone')->nullable();
            $table->longText('population')->nullable();
            $table->longText('body')->nullable();
            $table->longText('image')->nullable();
            $table->longText('supporting_documents')->nullable();
            $table->integer('nid')->nullable();
            $table->string('weight_value')->nullable();
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
        Schema::dropIfExists('wards');
    }
};
