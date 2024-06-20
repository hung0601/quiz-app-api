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
        Schema::table('study_sets', function (Blueprint $table) {
            $table->integer('access_type')->default(0)->comment(
                '0 public, 1 share with follower, 2 private'
            )->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_sets', function (Blueprint $table) {
            $table->dropColumn('access_type');
        });
    }
};
