<?php

namespace App\Policies;

use App\Models\IncompleteGrade;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IncompleteGradePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, IncompleteGrade $incompleteGrade): bool
    {
        // Allow the owner of the application to view it
        if ($user->id === $incompleteGrade->user_id) {
            return true;
        }
        
        // Allow deans to view applications from their college
        if ($user->role === 'dean' && $incompleteGrade->course->college === $user->college) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, IncompleteGrade $incompleteGrade): bool
    {
        return $user->id === $incompleteGrade->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, IncompleteGrade $incompleteGrade): bool
    {
        return $user->id === $incompleteGrade->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, IncompleteGrade $incompleteGrade): bool
    {
        return $user->id === $incompleteGrade->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, IncompleteGrade $incompleteGrade): bool
    {
        return $user->id === $incompleteGrade->user_id;
    }
}
