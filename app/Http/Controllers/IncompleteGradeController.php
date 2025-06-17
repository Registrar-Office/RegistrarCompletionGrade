<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\IncompleteGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncompleteGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $incompleteGrades = Auth::user()->incompleteGrades()->with('course')->get();
            return view('incomplete-grades.index', compact('incompleteGrades'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error loading incomplete grades: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        
        return view('incomplete-grades.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'reason_for_incompleteness' => 'required|string',
        ]);
        
        Auth::user()->incompleteGrades()->create([
            'course_id' => $request->course_id,
            'reason_for_incompleteness' => $request->reason_for_incompleteness,
            'submission_deadline' => now()->addMonths(3), // Default 3 months from now
            'status' => 'Pending',
        ]);
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncompleteGrade $incompleteGrade)
    {
        $this->authorize('view', $incompleteGrade);
        
        return view('incomplete-grades.show', compact('incompleteGrade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncompleteGrade $incompleteGrade)
    {
        $this->authorize('update', $incompleteGrade);
        
        $courses = Course::all();
        
        return view('incomplete-grades.edit', compact('incompleteGrade', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncompleteGrade $incompleteGrade)
    {
        $this->authorize('update', $incompleteGrade);
        
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'reason_for_incompleteness' => 'required|string',
        ]);
        
        $incompleteGrade->update([
            'course_id' => $request->course_id,
            'reason_for_incompleteness' => $request->reason_for_incompleteness,
        ]);
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request updated successfully.');
    }

    /**
     * Update the status of the incomplete grade.
     */
    public function updateStatus(Request $request, IncompleteGrade $incompleteGrade)
    {
        $this->authorize('update', $incompleteGrade);
        
        $request->validate([
            'status' => 'required|in:Pending,Submitted,Approved,Rejected',
        ]);
        
        $incompleteGrade->update([
            'status' => $request->status,
        ]);
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncompleteGrade $incompleteGrade)
    {
        $this->authorize('delete', $incompleteGrade);
        
        $incompleteGrade->delete();
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request deleted successfully.');
    }
}
