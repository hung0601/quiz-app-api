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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('selected_answer_id');
            $table->timestamps();

            $table->foreign('question_id')
            ->references('id')
            ->on('test_questions');

            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->foreign('selected_answer_id')
            ->references('id')
            ->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
