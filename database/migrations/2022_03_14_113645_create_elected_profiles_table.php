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
        Schema::create('elected_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments');
            $table->string('title')->nullable();
            $table->string('country_studied')->nullable();
            $table->string('study_institute')->nullable();
            $table->string('subject_of_the_study')->nullable();
            $table->longText('other')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email')->nullable();
            $table->longText('kriti_prakashan')->nullable();
            $table->string('date_of_birth_date')->nullable();
            $table->string('date_of_birth_month')->nullable();
            $table->string('date_of_birth_year')->nullable();
            $table->string('district')->nullable();
            $table->string('toll')->nullable();
            $table->string('husband_wife_name')->nullable();
            $table->text('position')->nullable();
            $table->text('region')->nullable();
            $table->longText('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('mobile')->nullable();
            $table->longText('political_experience')->nullable();
            $table->longText('political_party')->nullable();
            $table->string('gender')->nullable();
            $table->string('vada_no')->nullable();
            $table->text('past_occcupation_and_experience')->nullable();
            $table->longText('foreign_travel')->nullable();
            $table->longText('marital_status')->nullable();
            $table->longText('education_qualification')->nullable();
            $table->longText('local_level_type')->nullable();
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
        Schema::dropIfExists('elected_profiles');
    }
};
