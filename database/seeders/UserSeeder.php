<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                'name' => 'Test',
                'email' => 'test@example.com',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Manh Hung',
                'email' => 'hung@gmail.com',
                'password' => Hash::make('123'),
            ]
        ]);
    }
}
