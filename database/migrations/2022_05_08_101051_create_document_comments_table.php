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
        Schema::create('document_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('cascade');
            $table->text('message');
            $table->text('reply')->nullable();
            $table->boolean('is_replied')->default(0);
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
        Schema::dropIfExists('document_comments');
    }
};
