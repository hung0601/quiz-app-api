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
        Schema::create('study_set_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('study_set_id');
            $table->unsignedBigInteger('topic_id');
            $table->primary(['study_set_id', 'topic_id']);
            $table->timestamps();

            $table->foreign('study_set_id')
            ->references('id')
            ->on('study_sets');
            $table->foreign('topic_id')
            ->references('id')
            ->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_set_topics');
    }
};
