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
} 