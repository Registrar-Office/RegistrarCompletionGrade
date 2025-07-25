<?php

namespace App\Http\Controllers;

use App\Models\IncompleteGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GradeChecklist;
use App\Models\Course;
use App\Models\User;
use App\Models\Curriculum;

class FacultyDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of incomplete grade applications for the faculty member.
     */
    public function index()
    {
        $faculty = Auth::user();
        // Assuming instructor_name in course is the faculty's id_number
        $incompleteGrades = IncompleteGrade::whereHas('course', function($query) use ($faculty) {
                $query->where('instructor_name', $faculty->id_number);
            })
            ->with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('faculty.dashboard', compact('incompleteGrades'));
    }

    /**
     * Show a specific application for review.
     */
    public function show(IncompleteGrade $incompleteGrade)
    {
        $faculty = Auth::user();
        // Ensure the faculty is the instructor for this course
        if ($incompleteGrade->course->instructor_name !== $faculty->id_number) {
            abort(403, 'Unauthorized action.');
        }
        return view('faculty.show', compact('incompleteGrade'));
    }

    /**
     * Reject an application with a reason.
     */
    public function reject(Request $request, IncompleteGrade $incompleteGrade)
    {
        $faculty = Auth::user();
        if ($incompleteGrade->course->instructor_name !== $faculty->id_number) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);
        $incompleteGrade->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        return redirect()->route('faculty.dashboard')->with('success', 'Application rejected successfully.');
    }

    /**
     * Forward an application to the dean for approval.
     */
    public function forward(Request $request, IncompleteGrade $incompleteGrade)
    {
        $faculty = Auth::user();
        if ($incompleteGrade->course->instructor_name !== $faculty->id_number) {
            abort(403, 'Unauthorized action.');
        }
        // Only allow forwarding if not already submitted or processed
        if (!in_array($incompleteGrade->status, ['Pending', 'Rejected'])) {
            return redirect()->route('faculty.dashboard')->with('error', 'Only pending or rejected applications can be forwarded.');
        }
        $incompleteGrade->update([
            'status' => 'Submitted',
            'rejection_reason' => null,
        ]);
        return redirect()->route('faculty.dashboard')->with('success', 'Application forwarded to dean for approval.');
    }

    /**
     * Show and edit grade checklist for a course.
     */
    public function gradeChecklist(Request $request, $courseId)
    {
        $faculty = Auth::user();
        $course = Course::findOrFail($courseId);
        if ($course->instructor_name !== $faculty->id_number) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get all students
        $students = User::where('role', 'student')->get();
        
        // Get existing grade checklists
        $checklists = GradeChecklist::where('course_id', $courseId)->with('student')->get();
        
        // Get curriculum courses based on student's major
        $curriculumCourses = [];
        foreach ($students as $student) {
            if ($student->major) {
                // Extract the track from the major (Web Technology Track or Network Security Track)
                $track = null;
                if (strpos($student->major, 'Web Technology') !== false) {
                    $track = 'Web Technology Track';
                } elseif (strpos($student->major, 'Network Security') !== false) {
                    $track = 'Network Security Track';
                }
                
                if ($track) {
                    $studentCurriculumCourses = Curriculum::where('major', $track)->get();
                    $curriculumCourses[$student->id] = $studentCurriculumCourses;
                }
            }
        }
        
        return view('faculty.grade-checklist', compact('course', 'students', 'checklists', 'curriculumCourses'));
    }

    /**
     * Update a student's grade in the checklist.
     */
    public function updateGradeChecklist(Request $request, $courseId, $studentId)
    {
        $faculty = Auth::user();
        
        $request->validate([
            'grade' => 'required|in:Passed,Failed,INC,NFE',
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
        ]);
        
        // Find or create a course based on the curriculum subject
        $curriculumCourse = Course::where('code', $request->subject_code)->first();
        
        if (!$curriculumCourse) {
            $curriculumCourse = Course::create([
                'code' => $request->subject_code,
                'title' => $request->subject_name,
                'instructor_name' => $faculty->id_number,
                'college' => $faculty->college ?? 'College of Computer Studies',
            ]);
        } else {
            // Update the instructor_name if the course exists but has a different instructor
            if ($curriculumCourse->instructor_name !== $faculty->id_number) {
                $curriculumCourse->instructor_name = $faculty->id_number;
                $curriculumCourse->save();
            }
        }
        
        $checklist = GradeChecklist::firstOrNew([
            'student_id' => $studentId,
            'course_id' => $curriculumCourse->id,
        ]);
        
        $checklist->faculty_id = $faculty->id;
        $checklist->grade = $request->grade;
        $checklist->save();

        // If grade is Failed, INC, or NFE, update IncompleteGrade if it exists
        if (in_array($request->grade, ['Failed', 'INC', 'NFE'])) {
            $incompleteGrade = IncompleteGrade::where('user_id', $studentId)
                ->where('course_id', $curriculumCourse->id)
                ->first();
            if ($incompleteGrade) {
                $incompleteGrade->grade = $request->grade;
                $incompleteGrade->save();
            }
        }
        
        return redirect()->back()->with('success', 'Grade checklist updated successfully.');
    }

    /**
     * Show and edit the grade checklist for a specific student in a course.
     */
    public function showStudentChecklist($courseId, $studentId)
    {
        $faculty = Auth::user();
        $course = Course::findOrFail($courseId);
        
        // Allow access if this is a faculty member and either:
        // 1. The course belongs to them, OR
        // 2. The course has no assigned instructor (TBA) or placeholder data
        if ($course->instructor_name !== $faculty->id_number && 
            !in_array($course->instructor_name, ['TBA', 'N/A', null, ''])) {
            abort(403, 'Unauthorized action.');
        }
        
        $student = User::where('role', 'student')->findOrFail($studentId);
        $checklists = GradeChecklist::where('course_id', $courseId)->where('student_id', $studentId)->with('student')->get();
        $curriculumCourses = collect();
        if ($student->major) {
            $track = null;
            if (strpos($student->major, 'Web Technology') !== false) {
                $track = 'Web Technology Track';
            } elseif (strpos($student->major, 'Network Security') !== false) {
                $track = 'Network Security Track';
            }
            if ($track) {
                $curriculumCourses = Curriculum::where('major', $track)->get();
            }
        }
        return view('faculty.student-checklist', compact('course', 'student', 'checklists', 'curriculumCourses'));
    }
}