<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'faculty_id',
        'grade',
        'remarks',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
} 