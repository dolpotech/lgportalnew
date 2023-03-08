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
        Schema::create('local_governments', function (Blueprint $table) {
            $table->id();
            $table->biginteger('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->biginteger('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->integer('lg_no')->nullable();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('information_official_email')->nullable();
            $table->string('type')->nullable();
            $table->string('type_nep')->nullable();
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
        Schema::dropIfExists('local_governments');
    }
};
