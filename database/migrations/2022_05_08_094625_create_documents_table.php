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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unique(['info_receiver_id', 'field_id', 'main_doc']);
            $table->unsignedbiginteger('info_receiver_id');
            $table->foreign('info_receiver_id')->references('id')->on('info_receivers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('field_id')->nullable();
            $table->foreign('field_id')->references('id')->on('template_fields')->onDelete('cascade')->onUpdate('cascade');
            $table->text('answer')->nullable();
            $table->string('main_doc')->nullable();
            $table->string('main_doc_path')->nullable();
            $table->string('main_doc_type')->nullable();
            $table->string('supporting_doc')->nullable();
            $table->string('supporting_doc_path')->nullable();
            $table->string('supporting_doc_type')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
