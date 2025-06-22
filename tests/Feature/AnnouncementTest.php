<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_faculty_can_create_announcement_for_specific_student(): void
    {
        // Create a faculty user
        $faculty = User::factory()->create([
            'role' => 'faculty',
            'college' => 'College of Engineering',
            'id_number' => 'FAC-2025-001',
        ]);

        // Create a student user
        $student = User::factory()->create([
            'role' => 'student',
            'id_number' => '22-2014-166',
        ]);

        // Create a course
        $course = Course::create([
            'code' => 'CS101',
            'title' => 'Introduction to Computer Science',
            'instructor_name' => $faculty->id_number,
            'college' => 'College of Engineering',
        ]);

        $response = $this->actingAs($faculty)
            ->post('/announcement', [
                'course_id' => $course->id,
                'title' => 'Test Announcement',
                'body' => 'This is a test announcement for a specific student.',
                'target_student_id' => $student->id,
            ]);

        $response->assertRedirect('/announcement');
        $response->assertSessionHas('success', 'Announcement sent to student!');

        $this->assertDatabaseHas('announcements', [
            'title' => 'Test Announcement',
            'target_student_id' => $student->id,
            'user_id' => $faculty->id,
        ]);
    }

    public function test_student_can_only_see_general_and_targeted_announcements(): void
    {
        // Create users
        $faculty = User::factory()->create([
            'role' => 'faculty',
            'id_number' => 'FAC-2025-001',
        ]);
        $student1 = User::factory()->create([
            'role' => 'student', 
            'id_number' => '22-2014-166'
        ]);
        $student2 = User::factory()->create([
            'role' => 'student', 
            'id_number' => '22-2015-234'
        ]);

        // Create a course
        $course = Course::create([
            'code' => 'CS101',
            'title' => 'Introduction to Computer Science',
            'instructor_name' => $faculty->id_number,
            'college' => 'College of Engineering',
        ]);

        // Create announcements
        Announcement::create([
            'course_id' => $course->id,
            'title' => 'General Announcement',
            'body' => 'This is for all students.',
            'user_id' => $faculty->id,
            'target_student_id' => null,
        ]);

        Announcement::create([
            'course_id' => $course->id,
            'title' => 'Specific to Student 1',
            'body' => 'This is only for student 1.',
            'user_id' => $faculty->id,
            'target_student_id' => $student1->id,
        ]);

        Announcement::create([
            'course_id' => $course->id,
            'title' => 'Specific to Student 2',
            'body' => 'This is only for student 2.',
            'user_id' => $faculty->id,
            'target_student_id' => $student2->id,
        ]);

        // Student 1 should see general announcement and their specific announcement
        $response = $this->actingAs($student1)->get('/announcement');
        $response->assertStatus(200);
        $response->assertSee('General Announcement');
        $response->assertSee('Specific to Student 1');
        $response->assertDontSee('Specific to Student 2');

        // Student 2 should see general announcement and their specific announcement
        $response = $this->actingAs($student2)->get('/announcement');
        $response->assertStatus(200);
        $response->assertSee('General Announcement');
        $response->assertSee('Specific to Student 2');
        $response->assertDontSee('Specific to Student 1');
    }

    public function test_faculty_can_see_all_announcements(): void
    {
        // Create users
        $faculty = User::factory()->create([
            'role' => 'faculty',
            'id_number' => 'FAC-2025-001',
        ]);
        $student1 = User::factory()->create([
            'role' => 'student',
            'id_number' => '22-2014-166',
        ]);
        $student2 = User::factory()->create([
            'role' => 'student',
            'id_number' => '22-2015-234',
        ]);

        // Create a course
        $course = Course::create([
            'code' => 'CS101',
            'title' => 'Introduction to Computer Science',
            'instructor_name' => $faculty->id_number,
            'college' => 'College of Engineering',
        ]);

        // Create announcements
        Announcement::create([
            'course_id' => $course->id,
            'title' => 'General Announcement',
            'body' => 'This is for all students.',
            'user_id' => $faculty->id,
            'target_student_id' => null,
        ]);

        Announcement::create([
            'course_id' => $course->id,
            'title' => 'Specific to Student 1',
            'body' => 'This is only for student 1.',
            'user_id' => $faculty->id,
            'target_student_id' => $student1->id,
        ]);

        Announcement::create([
            'course_id' => $course->id,
            'title' => 'Specific to Student 2',
            'body' => 'This is only for student 2.',
            'user_id' => $faculty->id,
            'target_student_id' => $student2->id,
        ]);

        // Faculty should see all announcements
        $response = $this->actingAs($faculty)->get('/announcement');
        $response->assertStatus(200);
        $response->assertSee('General Announcement');
        $response->assertSee('Specific to Student 1');
        $response->assertSee('Specific to Student 2');
    }
}
