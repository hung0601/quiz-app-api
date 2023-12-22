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
            $table->unsignedBigInteger('term_referent_id');
            $table->string('question');
            $table->integer('point');
            $table->integer('type');
            $table->timestamps();

            $table->foreign('test_id')
            ->references('id')
            ->on('study_set_tests');

            $table->foreign('term_referent_id')
            ->references('id')
            ->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};
