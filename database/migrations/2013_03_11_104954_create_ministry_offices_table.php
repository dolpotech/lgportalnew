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
        Schema::create('ministry_offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('ministry_id');
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
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
        Schema::dropIfExists('ministry_departments');
    }

};
