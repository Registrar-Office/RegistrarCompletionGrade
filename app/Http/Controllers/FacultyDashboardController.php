<?php

namespace App\Http\Controllers;

use App\Models\IncompleteGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
} 