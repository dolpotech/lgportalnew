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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent_id')->default(0);
            $table->enum('type', ['ministry', 'local_government', 'ministry_office']);
            $table->unsignedbiginteger('lg_id')->nullable();
            $table->foreign('lg_id')->references('id')->on('local_governments')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('ministry_offices')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedbiginteger('ministry_department_id')->nullable();
            $table->foreign('ministry_department_id')->references('id')->on('ministry_departments')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_no', 20)->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }

};
