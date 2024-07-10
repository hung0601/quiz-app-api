<?php

namespace Database\Seeders;

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
            //User Manh Hung : 1
            [
                'title' => 'Vocabulary set about animals',
                'description' => 'Explore various animal names and their meanings in this comprehensive vocabulary set, designed to enhance your knowledge and understanding.',
                'image_url' => asset('storage/study_sets/set1.jpg'),
                'term_lang' => 'en',
                'owner_id' => 1,
                'course_id' => 5,
            ],
            [
                'title' => 'Bộ từ vựng về các loài hoa',
                'description' => 'Bao gồm từ vựng tiếng anh về các loài hoa',
                'image_url' => asset('storage/study_sets/set2.jpg'),
                'term_lang' => 'en',
                'owner_id' => 1,
                'course_id' => 5,
            ],
            [
                'title' => 'Vocabulary set about oceans',
                'description' => 'Explore the fascinating world of oceans with this English vocabulary set, covering marine life, oceanic features, and related terms.',
                'image_url' => asset('storage/study_sets/set3.jpg'),
                'term_lang' => 'en',
                'owner_id' => 1,
                'course_id' => 5,
            ],

            //User Cao Minh : 2
            [
                'title' => 'Các mẫu câu giao tiếp cơ bản trong tiếng Nhật',
                'description' => 'Một số thuật ngữ tiếng Nhật cơ bản',
                'image_url' => asset('storage/study_sets/set6.jpg'),
                'term_lang' => 'ja',
                'owner_id' => 2,
                'course_id' => null,
            ],
            [
                'title' => 'Kanji master N3 bài 1',
                'description' => 'Kanji trình độ N3',
                'image_url' => asset('storage/study_sets/set6.jpg'),
                'term_lang' => 'ja',
                'owner_id' => 2,
                'course_id' => 2,
            ],
            [
                'title' => 'Kanji master N3 bài 2',
                'description' => 'Kanji trình độ N3',
                'image_url' => asset('storage/study_sets/set6.jpg'),
                'term_lang' => 'ja',
                'owner_id' => 2,
                'course_id' => 2,
            ],

            //User The Thai: 3
            [
                'title' => 'Quốc kỳ',
                'description' => 'Nhận biết quốc kỳ các nước',
                'image_url' => asset('storage/study_sets/set4.jpg'),
                'term_lang' => 'en',
                'owner_id' => 3,
                'course_id' => null,
            ],
            [
                'title' => 'What is in the solar system?',
                'description' => 'The Solar System consists of the Sun and the celestial bodies orbiting it, including eight planets, moons, asteroids, and comets.',
                'image_url' => asset('storage/study_sets/set5.jpg'),
                'term_lang' => 'en',
                'owner_id' => 3,
                'course_id' => null,
            ],

            //Anh tuan: 4
            [
                'title' => 'Bảng tuần hoàn hóa học',
                'description' => 'Các nguyên tố trong bảng tuần hoàn hóa học',
                'image_url' => null,
                'term_lang' => 'en',
                'owner_id' => 4,
                'course_id' => 4,
            ],
            [
                'title' => 'English for Ict',
                'description' => 'Từ vựng tiếng anh chuyên ngành IT',
                'image_url' => null,
                'term_lang' => 'en',
                'owner_id' => 4,
                'course_id' => 3,
            ],
            [
                'title' => 'Mina no nihongo bài 1',
                'description' => 'Từ vựng tiếng Nhật',
                'image_url' => null,
                'term_lang' => 'ja',
                'owner_id' => 4,
                'course_id' => null,
            ],

            //Xuan nang: 5
            [
                'title' => '動物の世界レッスン 1',
                'description' => 'おなじみの動物たち。',
                'image_url' => null,
                'term_lang' => 'ja',
                'owner_id' => 5,
                'course_id' => 1,
            ],
            [
                'title' => '動物の世界レッスン 2',
                'description' => 'おなじみの動物たち。',
                'image_url' => null,
                'term_lang' => 'ja',
                'owner_id' => 5,
                'course_id' => 1,
            ],
            [
                'title' => '動物の世界レッスン 3',
                'description' => 'おなじみの動物たち。',
                'image_url' => null,
                'term_lang' => 'ja',
                'owner_id' => 5,
                'course_id' => 1,
            ],

            //Quang Huy: 6
            [
                'title' => 'Tiếng anh 1',
                'description' => 'Từ mới tiếng Anh',
                'image_url' => null,
                'term_lang' => 'en',
                'owner_id' => 6,
                'course_id' => null,
            ],
            [
                'title' => 'Tiếng anh 2',
                'description' => 'Từ mới tiếng Anh',
                'image_url' => null,
                'term_lang' => 'en',
                'owner_id' => 6,
                'course_id' => null,
            ],
            [
                'title' => 'Tiếng anh 3',
                'description' => 'Từ mới tiếng Anh',
                'image_url' => null,
                'term_lang' => 'en',
                'owner_id' => 6,
                'course_id' => null,
            ],

        ]);

        DB::table('study_set_topics')->insert([
            [
                'study_set_id' => 1,
                'topic_id' => 1,
            ],
            [
                'study_set_id' => 1,
                'topic_id' => 3,
            ],
            [
                'study_set_id' => 1,
                'topic_id' => 4,
            ],

            [
                'study_set_id' => 2,
                'topic_id' => 1,
            ],
            [
                'study_set_id' => 2,
                'topic_id' => 3,
            ],
            [
                'study_set_id' => 2,
                'topic_id' => 5,
            ],

            [
                'study_set_id' => 3,
                'topic_id' => 1,
            ],
            [
                'study_set_id' => 3,
                'topic_id' => 3,
            ],

            [
                'study_set_id' => 4,
                'topic_id' => 1,
            ],
            [
                'study_set_id' => 4,
                'topic_id' => 3,
            ],
        ]);
    }
}
