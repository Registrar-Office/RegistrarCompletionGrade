<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\GradeChecklist;
use App\Models\Curriculum;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show the student's grade checklist.
     */
    public function gradeChecklist()
    {
        $user = Auth::user();
        $checklists = $user->gradeChecklists()->with('course', 'faculty')->get();
        return view('profile.grade-checklist', compact('checklists'));
    }

    /**
     * Show the student's curriculum based on their major.
     */
    public function curriculum()
    {
        $user = Auth::user();
        
        // Extract the track from the major (e.g., "Web Technology Track" from "BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY/Web Technology Track")
        $majorParts = explode('/', $user->major);
        $track = isset($majorParts[1]) ? $majorParts[1] : null;
        
        if (!$track) {
            return redirect()->route('dashboard')->with('error', 'Unable to determine your track from your major.');
        }

        // Get curriculum by track, grouped by year and trimester
        $curriculumData = Curriculum::where('major', $track)
            ->orderBy('year')
            ->orderBy('trimester')
            ->orderBy('subject_code')
            ->get()
            ->groupBy(['year', 'trimester']);

        return view('profile.curriculum', compact('curriculumData', 'track', 'user'));
    }
}
