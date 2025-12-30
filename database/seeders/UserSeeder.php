<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@eees.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Instructor Account
        \App\Models\User::firstOrCreate(
            ['email' => 'instructor@eees.com'],
            [
                'name' => 'Instructor User',
                'password' => bcrypt('password'),
                'role' => 'instructor',
            ]
        );

        // Student Account
        \App\Models\User::firstOrCreate(
            ['email' => 'student@eees.com'],
            [
                'name' => 'Student User',
                'password' => bcrypt('password'),
                'role' => 'student', // Ensure this matches your enum/string 'student' or 'user'
            ]
        );
    }
}
