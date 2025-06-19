<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Announcement;

class AnnouncementTestSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::firstOrCreate([
            'code' => 'TEST101',
        ], [
            'title' => 'Test Course',
            'instructor_name' => 'FAC-2025-001',
            'college' => 'Test College',
        ]);

        $user = User::firstOrCreate([
            'id_number' => 'DEAN-2025-001',
        ], [
            'name' => 'Test Dean',
            'email' => 'dean@example.com',
            'password' => Hash::make('password'),
            'role' => 'dean',
            'college' => 'Test College',
        ]);

        // Create an announcement using the correct foreign keys
        Announcement::create([
            'course_id' => $course->id,
            'title' => 'Test Announcement',
            'body' => 'This is a test announcement for the course.',
            'user_id' => $user->id,
        ]);
    }
} 