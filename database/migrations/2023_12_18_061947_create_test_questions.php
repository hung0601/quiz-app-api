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
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('term_referent_id')->nullable();
            $table->boolean("has_audio")->default(false);
            $table->text("audio_text")->nullable();
            $table->string("audio_lang")->nullable();
            $table->morphs("question");
            $table->integer('point');
            $table->timestamps();

            $table->foreign('test_id')
            ->references('id')
            ->on('study_set_tests');

            $table->foreign('term_referent_id')
            ->references('id')
            ->on('terms');
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string("question");
            $table->json("answers");
            $table->integer('correct_answer');
            $table->timestamps();
        });

        Schema::create('true_false_questions', function (Blueprint $table) {
            $table->id();
            $table->string("question");
            $table->boolean('correct_answer');
            $table->timestamps();
        });

        Schema::create('type_answer_questions', function (Blueprint $table) {
            $table->id();
            $table->string("question");
            $table->string('correct_answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('true_false_questions');
        Schema::dropIfExists('type_answer_questions');
    }
};
