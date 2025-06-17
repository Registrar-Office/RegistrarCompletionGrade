<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\IncompleteGrade;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user with the specified ID and password
        $user = User::create([
            'name' => 'John Doe',
            'id_number' => '22-2014-166',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('Jeydicute1'),
        ]);

        // Create some courses
        $courses = [
            [
                'code' => 'CS101',
                'title' => 'Introduction to Computer Science',
                'instructor_name' => 'Dr. Smith',
            ],
            [
                'code' => 'MATH202',
                'title' => 'Calculus II',
                'instructor_name' => 'Prof. Johnson',
            ],
            [
                'code' => 'ENG110',
                'title' => 'English Composition',
                'instructor_name' => 'Dr. Williams',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }

        // Create some incomplete grades for the user
        $incompleteGrades = [
            [
                'user_id' => $user->id,
                'course_id' => 1,
                'reason_for_incompleteness' => 'Missed final exam due to illness',
                'submission_deadline' => now()->addDays(30),
                'status' => 'Pending',
            ],
            [
                'user_id' => $user->id,
                'course_id' => 2,
                'reason_for_incompleteness' => 'Incomplete project submission',
                'submission_deadline' => now()->addDays(15),
                'status' => 'Submitted',
            ],
            [
                'user_id' => $user->id,
                'course_id' => 3,
                'reason_for_incompleteness' => 'Missing term paper',
                'submission_deadline' => now()->addDays(7),
                'status' => 'Pending',
            ],
        ];

        foreach ($incompleteGrades as $grade) {
            IncompleteGrade::create($grade);
        }
    }
}
