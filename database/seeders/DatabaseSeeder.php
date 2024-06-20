<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();
//        $this->call([
//            UserSeeder::class,
//            CourseSeeder::class,
//            EnrollmentSeeder::class,
//            StudySetSeeder::class,
//            TermSeeder::class,
//            TopicSeeder::class,
//            TestSeeder::class,
//        ]);
    }
}
