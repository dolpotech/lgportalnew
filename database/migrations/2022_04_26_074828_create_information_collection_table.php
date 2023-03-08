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
        Schema::create('information_collection', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', getInfoCollectionType());
            $table->enum('agency_type', getUserType());
            $table->unsignedbiginteger('template_id')->nullable();
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade')->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->string('main_doc');
            $table->string('main_doc_path')->nullable();
            $table->string('main_doc_type')->nullable();
            $table->string('supporting_doc')->nullable();
            $table->string('supporting_doc_path')->nullable();
            $table->string('supporting_doc_type')->nullable();
            $table->json('document_type')->nullable();
            $table->unsignedbiginteger('assigner_id');
            $table->foreign('assigner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('priority', getPriorityLevel())->default('medium');
            $table->date('start_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->enum('status', getInformationStatus())->default('processing');
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
        Schema::dropIfExists('information_collection');
    }
};
