<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createTime = Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'Mạnh Hùng',
                'email' => 'manhhung@gmail.com',
                'image_url' => asset('storage/avatars/avatar1.jpeg'),
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Cao Minh',
                'email' => 'caominh@gmail.com',
                'password' => Hash::make('password'),
                'image_url' => asset('storage/avatars/avatar2.jpg'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Thế Thái',
                'email' => 'thethai@gmail.com',
                'password' => Hash::make('password'),
                'image_url' => asset('storage/avatars/avatar3.jpg'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Anh Tuấn',
                'email' => 'anhtuan@gmail.com',
                'image_url' => asset('storage/avatars/avatar4.jpg'),
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Xuân Năng',
                'email' => 'xuannang@gmail.com',
                'image_url' => asset('storage/avatars/avatar5.jpg'),
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Quang Huy',
                'email' => 'quanghuy@gmail.com',
                'image_url' => asset('storage/avatars/avatar6.jpg'),
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'John Cena',
                'email' => 'johncena@gmail.com',
                'image_url' => null,
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Chris Pratt',
                'email' => 'chrisparatt@gmail.com',
                'image_url' => null,
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Hugh Jackman',
                'email' => 'hughjackman@gmail.com',
                'image_url' => null,
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ],
            [
                'name' => 'Justin Bieber',
                'email' => 'justinbieber@gmail.com',
                'image_url' => null,
                'password' => Hash::make('password'),
                'created_at' => $createTime,
            ]
        ]);

        User::factory()->count(40)->create();
    }
}
