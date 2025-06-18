<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'title',
        'instructor_name',
        'college',
    ];
    
    /**
     * Get the incomplete grades for the course.
     */
    public function incompleteGrades(): HasMany
    {
        return $this->hasMany(IncompleteGrade::class);
    }
}
