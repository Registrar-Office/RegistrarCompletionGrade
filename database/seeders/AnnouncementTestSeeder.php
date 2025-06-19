<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    }
} 