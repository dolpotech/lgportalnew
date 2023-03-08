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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('ministry_offices')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('lg_id')->nullable();
            $table->foreign('lg_id')->references('id')->on('local_governments')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_custom')->default(0);
            $table->boolean('to_email')->default(0);
            $table->boolean('to_sms')->default(0);
            $table->boolean('is_sent')->default(0);
            $table->smallInteger('sent_count')->default(0);
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
        Schema::dropIfExists('notifications');
    }
};
