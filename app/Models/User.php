<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'id_number',
        'email',
        'password',
        'role',
        'college',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the incomplete grades for the user.
     */
    public function incompleteGrades(): HasMany
    {
        return $this->hasMany(IncompleteGrade::class);
    }
    
    /**
     * Get the signature associated with the user.
     */
    public function signature(): HasOne
    {
        return $this->hasOne(Signature::class);
    }

    /**
     * Check if the user is a dean.
     */
    public function isDean(): bool
    {
        return $this->role === 'dean';
    }

    /**
     * Check if the user is a faculty member.
     */
    public function isFaculty(): bool
    {
        return $this->role === 'faculty';
    }

    /**
     * Override the default authentication identifier to use id_number instead of email.
     */
    public function getAuthIdentifierName()
    {
        return 'id_number';
    }

    /**
     * Get the grade checklists for the student.
     */
    public function gradeChecklists()
    {
        return $this->hasMany(\App\Models\GradeChecklist::class, 'student_id');
    }

    /**
     * Get the grade checklists for the faculty.
     */
    public function facultyGradeChecklists()
    {
        return $this->hasMany(\App\Models\GradeChecklist::class, 'faculty_id');
    }
}
