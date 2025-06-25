<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\User;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'student') {
            // Students see general announcements and those targeted to them
            $announcements = Announcement::latest()
                ->with(['user', 'targetStudent'])
                ->where(function($query) use ($user) {
                    $query->whereNull('target_student_id')  // General announcements
                          ->orWhere('target_student_id', $user->id);  // Targeted to this student
                })
                ->get();
        } else {
            // Faculty and Dean see all announcements
            $announcements = Announcement::latest()->with(['user', 'targetStudent'])->get();
        }
        
        return view('announcement.index', compact('announcements'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $courses = Course::all();
        $students = User::where('role', 'student')->get();
        return view('announcement.create', compact('courses', 'students'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target_student_id' => 'nullable|exists:users,id',
        ]);

        // Verify that the target student is actually a student
        if ($validated['target_student_id']) {
            $targetStudent = User::find($validated['target_student_id']);
            if ($targetStudent->role !== 'student') {
                return back()->withErrors(['target_student_id' => 'The selected user is not a student.'])->withInput();
            }
        }

        Announcement::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'target_student_id' => $validated['target_student_id'],
            'user_id' => Auth::user()->id,
        ]);

        $message = $validated['target_student_id'] ? 'Announcement sent to student!' : 'Announcement created!';
        return redirect()->route('announcement.index')->with('success', $message);
    }

    public function edit(Announcement $announcement)
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $courses = Course::all();
        $students = User::where('role', 'student')->get();
        return view('announcement.edit', compact('announcement', 'courses', 'students'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target_student_id' => 'nullable|exists:users,id',
        ]);

        // Verify that the target student is actually a student
        if ($validated['target_student_id']) {
            $targetStudent = User::find($validated['target_student_id']);
            if ($targetStudent->role !== 'student') {
                return back()->withErrors(['target_student_id' => 'The selected user is not a student.'])->withInput();
            }
        }

        $announcement->update([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'target_student_id' => $validated['target_student_id'],
        ]);

        $message = $validated['target_student_id'] ? 'Announcement updated and sent to student!' : 'Announcement updated!';
        return redirect()->route('announcement.index')->with('success', $message);
    }

    public function destroy(Announcement $announcement)
    {
        // Only allow the author to delete
        if (Auth::user() && Auth::user()->id == $announcement->user_id) {
            $announcement->delete();
            return redirect()->route('announcement.index')->with('success', 'Announcement deleted successfully.');
        }
        abort(403, 'Unauthorized action.');
    }
} 