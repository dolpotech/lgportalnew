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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->biginteger('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->integer('district_no')->nullable();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->integer('ward_count')->nullable();
            $table->string('population')->nullable();
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
        Schema::dropIfExists('districts');
    }
};
