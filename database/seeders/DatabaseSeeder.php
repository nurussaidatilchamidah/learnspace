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

        $data = [
            [
                'title' => 'UX Design Foundations', 'category' => 'Design', 'level' => 'Beginner', 'status' => 'published',
                'description' => 'Great design starts with understanding people. Learn the methods, mindset, and tools to create experiences that truly matter.',
                'lessons' => [
                    ['What is user experience?', 'Pengenalan konsep UX dan mengapa pengalaman pengguna penting.'],
                    ['Understanding your users', 'Belajar mengamati, bertanya, dan mendengarkan kebutuhan pengguna.'],
                    ['The human-centered design process', 'Tahapan proses desain yang berpusat pada manusia.'],
                ],
            ],
            [
                'title' => 'UI Design Masterclass', 'category' => 'Design', 'level' => 'Intermediate', 'status' => 'published',
                'description' => 'Craft every detail. Dari warna, tipografi, hingga komponen antarmuka yang konsisten.',
                'lessons' => [
                    ['Color and typography basics', 'Dasar pemilihan warna dan huruf untuk antarmuka.'],
                    ['Building reusable components', 'Membuat komponen yang bisa dipakai ulang.'],
                ],
            ],
            [
                'title' => 'JavaScript Essentials', 'category' => 'Development', 'level' => 'Beginner', 'status' => 'published',
                'description' => 'Start with the fundamentals: variabel, fungsi, dan manipulasi DOM.',
                'lessons' => [
                    ['Variables and data types', 'Mengenal variabel, tipe data, dan operator.'],
                    ['Functions and scope', 'Cara menulis fungsi dan memahami scope.'],
                    ['Working with the DOM', 'Mengubah isi halaman dengan JavaScript.'],
                ],
            ],
            [
                'title' => 'Product Management 101', 'category' => 'Business', 'level' => 'Beginner', 'status' => 'draft',
                'description' => 'From vision to real-world value. Course ini masih dalam tahap penyusunan.',
                'lessons' => [
                    ['What does a product manager do?', 'Peran dan tanggung jawab product manager.'],
                ],
            ],
        ];

        foreach ($data as $item) {
            $lessons = $item['lessons'];
            unset($item['lessons']);

            $course = Course::create($item);

            foreach ($lessons as $i => [$title, $description]) {
                $course->lessons()->create([
                    'title' => $title,
                    'description' => $description,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}