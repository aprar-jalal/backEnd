<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'role_id' => 1,
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'phone' => '0593083866',
                'location' => 'New York',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
