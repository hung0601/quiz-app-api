<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'title'=> 'Tiếng Nhật N3',
                'description'=>'Khóa học tiếng Nhật trình độ N3',
                'owner_id'=>2
            ],
            [
                'title'=> 'Kanji master N2',
                'description'=>'Tổng hợp kanji N2',
                'owner_id'=>2
            ],
            [
                'title'=> 'English for It',
                'description'=>'Tổng hợp từ vựng chuyên ngành IT',
                'owner_id'=>1
            ],
            [
                'title'=> 'Bảng tuần hoàn hóa học',
                'description'=>'Kí hiệu của các nguyên tố hóa học',
                'owner_id'=>1
            ]
        ]);
    }
}
