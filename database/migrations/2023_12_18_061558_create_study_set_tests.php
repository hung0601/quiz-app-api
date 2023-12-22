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
        Schema::create('study_set_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_set_id');
            $table->string('test_name');
            $table->timestamps();
            
            $table->foreign('study_set_id')
            ->references('id')
            ->on('study_sets');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_set_tests');
    }
};
