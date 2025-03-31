<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'manager@example.com',
                'password' => bcrypt('123456789'),
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'role_id' => 1
            ],
            [
                'email' => 'moderator@example.com',
                'password' => bcrypt('123456789'),
                'first_name' => 'Michał',
                'last_name' => 'Nowak',
                'role_id' => 2
            ],
            [
                'email' => 'seller@example.com',
                'password' => bcrypt('123456789'),
                'first_name' => 'Michał',
                'last_name' => 'Nowak',
                'role_id' => 2
            ]
        ]);
    }
}
