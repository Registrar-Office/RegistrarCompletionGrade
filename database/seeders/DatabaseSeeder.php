<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\IncompleteGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a student user with the specified ID and password
        $student = User::create([
            'name' => 'John Doe',
            'id_number' => '22-2014-166',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('Jeydicute1'),
            'role' => 'student',
            'major' => 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY/Web Technology Track',
        ]);
        
        // Create another student user
        $student2 = User::create([
            'name' => 'Jane Doe',
            'id_number' => '22-2015-234',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'major' => 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY/Network Security Track',
        ]);
        
        // Create a dean user
        $dean = User::create([
            'name' => 'Dr. Jane Smith',
            'id_number' => 'DEAN-2025-001',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'role' => 'dean',
            'college' => 'College of Engineering',
        ]);
        
        // Create a faculty user
        $faculty = User::create([
            'name' => 'Prof. Robert Johnson',
            'id_number' => 'FAC-2025-001',
            'email' => 'robert.johnson@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty',
            'college' => 'College of Engineering',
        ]);

        // Create some courses and store their IDs
        $courseRecords = [];
        foreach ([
            [
                'code' => 'CS101',
                'title' => 'Introduction to Computer Science',
                'instructor_name' => 'FAC-2025-001',
                'college' => 'College of Engineering',
            ],
            [
                'code' => 'MATH202',
                'title' => 'Calculus II',
                'instructor_name' => 'FAC-2025-001',
                'college' => 'College of Engineering',
            ],
            [
                'code' => 'ENG110',
                'title' => 'English Composition',
                'instructor_name' => 'FAC-2025-001',
                'college' => 'College of Liberal Arts',
            ],
        ] as $course) {
            $courseRecords[] = Course::create($course);
        }

        // DO NOT pre-create incomplete grades
        // Students should start with empty dashboards
        // Faculty will create incomplete grades when they mark students as Failed/INC/NFE
        
        // Seed curriculum data
        $this->call(CurriculumSeeder::class);
        
        // Always seed a test course and dean for announcement testing
        $this->call(AnnouncementTestSeeder::class);
    }
}
