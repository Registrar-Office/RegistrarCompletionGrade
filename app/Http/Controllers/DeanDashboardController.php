<?php

namespace App\Http\Controllers;

use App\Models\IncompleteGrade;
use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DeanDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of pending applications for the dean's college.
     */
    public function index()
    {
        $dean = Auth::user();
        $pendingApplications = IncompleteGrade::whereHas('course', function($query) use ($dean) {
                $query->where('college', $dean->college);
            })
            ->with(['user', 'course'])
            ->where('status', 'Pending')
            ->orderBy('submission_deadline')
            ->paginate(10);
        
        return view('dean.dashboard', compact('pendingApplications'));
    }

    /**
     * Display form to manage digital signature.
     */
    public function manageSignature()
    {
        $user = Auth::user();
        $signature = $user->signature;
        
        return view('dean.signature', compact('signature'));
    }

    /**
     * Store a new digital signature.
     */
    public function storeSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required',
        ]);
        
        $user = Auth::user();
        $signatureData = $request->input('signature_data');
        
        // Convert data URL to image and store it
        $image_parts = explode(";base64,", $signatureData);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'signature_' . $user->id . '_' . time() . '.png';
        Storage::put('signatures/' . $fileName, $image_base64);
        
        // Create or update the signature
        if ($user->signature) {
            // Delete old signature file if exists
            if ($user->signature->signature_image) {
                Storage::delete('signatures/' . $user->signature->signature_image);
            }
            
            $user->signature->update([
                'signature_image' => $fileName,
                'signature_data' => $signatureData,
            ]);
        } else {
            Signature::create([
                'user_id' => $user->id,
                'signature_image' => $fileName,
                'signature_data' => $signatureData,
            ]);
        }
        
        return redirect()->route('dean.signature')->with('success', 'Signature updated successfully.');
    }
    
    /**
     * Show a specific application.
     */
    public function show(IncompleteGrade $incompleteGrade)
    {
        $dean = Auth::user();
        
        // Check if this application belongs to the dean's college
        if ($incompleteGrade->course->college !== $dean->college) {
            return redirect()->route('dean.dashboard')->with('error', 'You do not have permission to view this application.');
        }
        
        return view('dean.show', compact('incompleteGrade'));
    }

    /**
     * Approve a specific application.
     */
    public function approve(IncompleteGrade $incompleteGrade)
    {
        $dean = Auth::user();
        
        // Check if this application belongs to the dean's college
        if ($incompleteGrade->course->college !== $dean->college) {
            return redirect()->route('dean.dashboard')->with('error', 'You do not have permission to approve this application.');
        }
        
        // Check if the dean has a signature
        if (!$dean->signature) {
            return redirect()->route('dean.signature')->with('error', 'You need to create a digital signature before approving applications.');
        }
        
        // Update the application status
        $incompleteGrade->update([
            'status' => 'Approved',
        ]);
        
        // Update the last_used timestamp for the signature
        $dean->signature->update([
            'last_used' => now(),
        ]);
        
        // Send email notification to the faculty
        $this->sendApprovalEmail($incompleteGrade);
        
        return redirect()->route('dean.dashboard')->with('success', 'Application approved successfully.');
    }

    /**
     * Bulk approve multiple applications.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'selected_applications' => 'required|array',
            'selected_applications.*' => 'exists:incomplete_grades,id',
        ]);
        
        $dean = Auth::user();
        
        // Check if the dean has a signature
        if (!$dean->signature) {
            return redirect()->route('dean.signature')->with('error', 'You need to create a digital signature before approving applications.');
        }
        
        $applicationIds = $request->input('selected_applications');
        $applications = IncompleteGrade::whereIn('id', $applicationIds)
            ->whereHas('course', function($query) use ($dean) {
                $query->where('college', $dean->college);
            })
            ->get();
        
        foreach ($applications as $application) {
            $application->update([
                'status' => 'Approved',
            ]);
            
            // Send email notification
            $this->sendApprovalEmail($application);
        }
        
        // Update the last_used timestamp for the signature
        $dean->signature->update([
            'last_used' => now(),
        ]);
        
        return redirect()->route('dean.dashboard')->with('success', count($applications) . ' applications approved successfully.');
    }
    
    /**
     * Reject a specific application.
     */
    public function reject(Request $request, IncompleteGrade $incompleteGrade)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);
        
        $dean = Auth::user();
        
        // Check if this application belongs to the dean's college
        if ($incompleteGrade->course->college !== $dean->college) {
            return redirect()->route('dean.dashboard')->with('error', 'You do not have permission to reject this application.');
        }
        
        // Update the application status
        $incompleteGrade->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        
        // Send email notification to the faculty
        // This would be implemented similarly to the approval email
        
        return redirect()->route('dean.dashboard')->with('success', 'Application rejected successfully.');
    }
    
    /**
     * Send email notification to faculty about approval.
     */
    private function sendApprovalEmail(IncompleteGrade $incompleteGrade)
    {
        $faculty = User::where('role', 'faculty')
            ->where('id_number', $incompleteGrade->course->instructor_name)
            ->first();
            
        if ($faculty) {
            // This would be implemented with Laravel's Mail functionality
            // Simulating email sending for now
            // Mail::to($faculty->email)->send(new ApplicationApproved($incompleteGrade));
            
            // Log the email sending (for development purposes)
            \Log::info('Email sent to ' . $faculty->email . ' about approval of application ID ' . $incompleteGrade->id);
        }
    }
}
