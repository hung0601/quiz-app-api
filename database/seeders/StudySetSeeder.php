<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StudySetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('study_sets')->insert([
            [
                'title' => 'Bộ từ vựng về động vật',
                'description' => 'Bao gồm từ vựng tiếng anh về các con vật quen thuộc',
                'image_url' => asset('storage/study_sets/set1.jpg'),
                'owner_id'=>2,
                'course_id'=>1,
            ],
            [
                'title' => 'Bộ từ vựng về các loài hoa',
                'description' => 'Bao gồm từ vựng tiếng anh về các loài hoa',
                'image_url' => asset('storage/study_sets/set2.jpg'),
                'owner_id'=>2,
                'course_id'=>1,
            ],
            [
                'title' => 'Toán học',
                'description' => 'Một số khái niệm toán học',
                'image_url' => asset('storage/study_sets/set3.jpg'),
                'owner_id'=>2,
                'course_id'=>2,
            ],
            [
                'title' => 'Quốc kỳ',
                'description' => 'Nhận biết quốc kỳ các nước',
                'image_url' => asset('storage/study_sets/set4.jpg'),
                'owner_id'=>2,
                'course_id'=>2,
            ],
            [
                'title' => 'Hành tinh',
                'description' => 'Các hành tinh trong hệ mặt trời',
                'image_url' => asset('storage/study_sets/set5.jpg'),
                'owner_id'=>1,
                'course_id'=>null,
            ],
            [
                'title' => 'Tiếng Nhật 1',
                'description' => 'Một số thuật ngữ tiếng Nhật cơ bản',
                'image_url' => asset('storage/study_sets/set6.jpg'),
                'owner_id'=>1,
                'course_id'=>null,
            ],
        ]);
    }
}
