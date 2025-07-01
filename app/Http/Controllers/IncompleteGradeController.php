<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\IncompleteGrade;
use App\Models\User;
use App\Models\GradeChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        // Only show courses where the current student has been marked as Failed, INC, or NFE by faculty
        $failedCourses = Course::whereHas('gradeChecklists', function ($query) {
            $query->where('student_id', Auth::id())
                  ->whereIn('grade', ['Failed', 'INC', 'NFE']);
        })->get();
        
        return view('incomplete-grades.create', compact('failedCourses'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Status flow:
     * 1. 'Pending' - Initial status when student creates the request (draft)
     * 2. 'Submitted' - When student submits the request for dean's review
     * 3. 'Approved' - When dean approves the request
     * 4. 'Rejected' - When dean rejects the request
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => [
                'required',
                'exists:courses,id',
                function ($attribute, $value, $fail) {
                    // Ensure the student can only create requests for courses they actually failed
                    $hasFailedGrade = GradeChecklist::where('student_id', Auth::id())
                        ->where('course_id', $value)
                        ->whereIn('grade', ['Failed', 'INC', 'NFE'])
                        ->exists();
                    
                    if (!$hasFailedGrade) {
                        $fail('You can only create requests for courses where you have been marked as Failed, INC, or NFE by faculty.');
                    }
                }
            ],
            'reason_for_incompleteness' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        $data = [
            'course_id' => $request->course_id,
            'reason_for_incompleteness' => $request->reason_for_incompleteness,
            'submission_deadline' => now()->addMonths(3), // Default 3 months from now
            'status' => 'Pending', // Initial status is Pending (draft)
        ];
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('incomplete-grade-attachments', 'public');
            $data['attachment_path'] = $path;
        }
        
        Auth::user()->incompleteGrades()->create($data);
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request created successfully. Please submit it for review when ready.');
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
        
        // Only show courses where the current student has been marked as Failed, INC, or NFE by faculty
        $failedCourses = Course::whereHas('gradeChecklists', function ($query) {
            $query->where('student_id', Auth::id())
                  ->whereIn('grade', ['Failed', 'INC', 'NFE']);
        })->get();
        
        return view('incomplete-grades.edit', compact('incompleteGrade', 'failedCourses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncompleteGrade $incompleteGrade)
    {
        $this->authorize('update', $incompleteGrade);
        
        $request->validate([
            'course_id' => [
                'required',
                'exists:courses,id',
                function ($attribute, $value, $fail) {
                    // Ensure the student can only update to courses they actually failed
                    $hasFailedGrade = GradeChecklist::where('student_id', Auth::id())
                        ->where('course_id', $value)
                        ->whereIn('grade', ['Failed', 'INC', 'NFE'])
                        ->exists();
                    
                    if (!$hasFailedGrade) {
                        $fail('You can only create requests for courses where you have been marked as Failed, INC, or NFE by faculty.');
                    }
                }
            ],
            'reason_for_incompleteness' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        $data = [
            'course_id' => $request->course_id,
            'reason_for_incompleteness' => $request->reason_for_incompleteness,
        ];
        
        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($incompleteGrade->attachment_path) {
                Storage::disk('public')->delete($incompleteGrade->attachment_path);
            }
            
            $path = $request->file('attachment')->store('incomplete-grade-attachments', 'public');
            $data['attachment_path'] = $path;
        }
        
        $incompleteGrade->update($data);
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request updated successfully.');
    }

    /**
     * Update the status of the incomplete grade.
     * 
     * This method is used when a student submits a pending request for review.
     */
    public function updateStatus(Request $request, IncompleteGrade $incompleteGrade)
    {
        $this->authorize('update', $incompleteGrade);
        
        $request->validate([
            'status' => 'required|in:Pending,Submitted,Approved,Rejected',
        ]);
        
        // Only allow status change from Pending to Submitted for students
        if (Auth::user()->role === 'student' && $request->status === 'Submitted' && $incompleteGrade->status === 'Pending') {
            $incompleteGrade->update([
                'status' => $request->status,
            ]);
            
            return redirect()->route('incomplete-grades.index')
                ->with('success', 'Your request has been submitted for review.');
        }
        
        // For other roles or status changes
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
        
        // Delete attachment if exists
        if ($incompleteGrade->attachment_path) {
            Storage::disk('public')->delete($incompleteGrade->attachment_path);
        }
        
        $incompleteGrade->delete();
        
        return redirect()->route('incomplete-grades.index')
            ->with('success', 'Incomplete grade request deleted successfully.');
    }
    
    /**
     * Allow students to view their approval documents.
     */
    public function viewApprovalDocument(IncompleteGrade $incompleteGrade)
    {
        $this->authorize('view', $incompleteGrade);
        
        // Check if the application is approved
        if ($incompleteGrade->status !== 'Approved') {
            return redirect()->route('incomplete-grades.index')
                ->with('error', 'Approval document is only available for approved applications.');
        }
        
        // Get the dean for this college
        $dean = User::where('role', 'dean')
            ->where('college', $incompleteGrade->course->college)
            ->first();
            
        if (!$dean) {
            return redirect()->route('incomplete-grades.index')
                ->with('error', 'Could not find the dean information for this document.');
        }
        
        return view('dean.approval-document', compact('incompleteGrade', 'dean'));
    }
    
    /**
     * Download the attachment file.
     */
    public function downloadAttachment(IncompleteGrade $incompleteGrade)
    {
        $this->authorize('view', $incompleteGrade);
        
        if (!$incompleteGrade->attachment_path) {
            return redirect()->back()->with('error', 'No attachment found for this request.');
        }
        
        return Storage::disk('public')->download($incompleteGrade->attachment_path);
    }
}
