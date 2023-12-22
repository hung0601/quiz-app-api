<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->insert([
            [
                'study_set_id' => 1,
                'term' => 'Lion',
                'definition'=>'Sư tử',
                'image_url' => asset('storage/terms/term1.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Cow',
                'definition'=>'Con bò',
                'image_url' => asset('storage/terms/term2.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Tiger',
                'definition'=>'Con hổ',
                'image_url' => asset('storage/terms/term3.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Polar bears',
                'definition'=>'Gấu Bắc cực',
                'image_url' => asset('storage/terms/term4.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Lioness',
                'definition' => 'Sư tử cái',
                'image_url' => asset('storage/terms/term9.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Zebra',
                'definition' => 'Ngựa vằn',
                'image_url' => asset('storage/terms/term10.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Koala',
                'definition' => 'Gấu túi Úc',
                'image_url' => asset('storage/terms/term11.jpg')
            ],
            [
                'study_set_id' => 1,
                'term' => 'Dolphin',
                'definition' => 'Cá heo',
                'image_url' => asset('storage/terms/term12.jpg')
            ],
            [
                'study_set_id' => 2,
                'term' => 'Tulips',
                'definition'=>'Hoa tulip',
                'image_url' => asset('storage/terms/term5.jpg')
            ],
            [
                'study_set_id' => 2,
                'term' => 'Rose',
                'definition'=>'Hoa hồng',
                'image_url' => asset('storage/terms/term6.jpg')
            ],
            [
                'study_set_id' => 2,
                'term' => 'Orchid',
                'definition'=>'Hoa lan',
                'image_url' => asset('storage/terms/term7.jpg')
            ],
            [
                'study_set_id' => 2,
                'term' => 'Chrysanthemum',
                'definition'=>'Hoa cúc',
                'image_url' => asset('storage/terms/term8.jpg')
            ],
        ]);
    }
}
