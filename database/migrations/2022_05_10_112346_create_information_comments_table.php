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
        Schema::create('information_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('information_id');
            $table->foreign('information_id')->references('id')->on('information_collection')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('commenter_id');
            $table->foreign('commenter_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('comment');
            $table->string('reply')->nullable();
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
        Schema::dropIfExists('information_comments');
    }
};
