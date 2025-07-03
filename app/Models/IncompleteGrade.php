<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncompleteGrade extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'reason_for_incompleteness',
        'submission_deadline',
        'status',
        'rejection_reason',
        'attachment_path',
        'grade',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submission_deadline' => 'date',
    ];
    
    /**
     * Get the user that owns the incomplete grade.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the course that owns the incomplete grade.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
