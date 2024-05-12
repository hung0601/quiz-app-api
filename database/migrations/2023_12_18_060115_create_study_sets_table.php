<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->foreign('owner_id')
            ->references('id')
            ->on('users');
        });
        Schema::create('study_sets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->string('term_lang')->default('en');
            $table->string('def_lang')->default('en');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
            $table->foreign('owner_id')
            ->references('id')
            ->on('users');
        });
        Schema::create('enrollments', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['course_id', 'user_id']);
            $table->timestamps();

            $table->foreign('course_id')
            ->references('id')
            ->on('courses');
            $table->foreign('user_id')
            ->references('id')
            ->on('users');

        });
        Schema::create('enrollment_requests', function(Blueprint $table){
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('participant_id');
            $table->enum('type',['invite','request']); // 1 invite, 2 request
            $table->timestamps();
            $table->primary(['course_id', 'participant_id']);
            $table->foreign('course_id')
            ->references('id')
            ->on('courses');
            $table->foreign('participant_id')
            ->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_requests');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('study_sets');
        Schema::dropIfExists('courses');
    }
};
