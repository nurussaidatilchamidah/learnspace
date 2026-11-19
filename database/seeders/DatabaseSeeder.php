<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Jordan Lee',
            'email' => 'admin@learnspace.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Alex Morgan',
            'email' => 'student@learnspace.test',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $courses = [
            ['UX Design Foundations', 'Design', 'Beginner', 'published'],
            ['UI Design Masterclass', 'Design', 'Intermediate', 'published'],
            ['JavaScript Essentials', 'Development', 'Beginner', 'published'],
            ['Product Management 101', 'Business', 'Beginner', 'draft'],
        ];

        foreach ($courses as [$title, $category, $level, $status]) {
            Course::create([
                'title' => $title,
                'description' => "Pelajari $title dari dasar dengan materi video yang terstruktur.",
                'category' => $category,
                'level' => $level,
                'status' => $status,
            ]);
        }
    }
}