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
        Schema::create('template_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade')->onUpdate('cascade');
            $table->text('name');
            $table->enum('type', getFieldTypes())->default('text');
            $table->string('default')->nullable();
            $table->boolean('is_required')->default(0);
            $table->text('options')->nullable();
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
        Schema::dropIfExists('template_fields');
    }
};
