<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'title' => 'Laravel Basics',
            'description' => 'Learn the fundamentals of Laravel.',
            'duration_hours' => 10,
        ]);

        Course::create([
            'title' => 'Advanced PHP',
            'description' => 'Deep dive into PHP concepts.',
            'duration_hours' => 20,
        ]);

        Course::create([
            'title' => 'Database Design',
            'description' => 'Master database architecture.',
            'duration_hours' => 15,
        ]);
    }
}



