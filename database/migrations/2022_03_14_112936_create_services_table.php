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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lg_id');
            $table->foreign('lg_id')->references('id')->on('local_governments');
            $table->text('title');
            $table->text('language')->nullable();
            $table->text('service_type')->nullable();
            $table->text('service_time')->nullable();
            $table->text('responsible_officer')->nullable();
            $table->text('service_office')->nullable();
            $table->string('service_fee')->nullable();
            $table->longText('required_documents')->nullable();
            $table->longText('related_documents')->nullable();
            $table->longText('process')->nullable();
            $table->longText('body')->nullable();
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
        Schema::dropIfExists('services');
    }
};
