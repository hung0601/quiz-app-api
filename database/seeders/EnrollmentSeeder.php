<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('enrollments')->insert([
            [
                'user_id'=> 1,
                'course_id'=>1,
            ],
            [
                'user_id'=> 1,
                'course_id'=>2,
            ],
            [
                'user_id'=> 2,
                'course_id'=>3,
            ],
            [
                'user_id'=> 2,
                'course_id'=>4,
            ],
        ]);
    }
}
