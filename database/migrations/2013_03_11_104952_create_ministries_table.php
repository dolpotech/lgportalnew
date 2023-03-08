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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->on('provinces')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('ministries');
    }
};
