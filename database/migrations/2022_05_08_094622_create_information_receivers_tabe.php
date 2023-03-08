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
        Schema::create('info_receivers', function (Blueprint $table) {
            $table->id();
            $table->unique(['information_id', 'ministry_id', 'office_id', 'lg_id']);
            $table->unsignedbiginteger('information_id');
            $table->foreign('information_id')->references('id')->on('information_collection')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('ministry_offices')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('lg_id')->nullable();
            $table->foreign('lg_id')->references('id')->on('local_governments')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_opened')->default(0);
            $table->timestamp('when_opened')->nullable();
            $table->enum('status', getDocumentStatus())->default('processing');
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
        Schema::dropIfExists('info_receivers');
    }
};
