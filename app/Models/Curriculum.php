<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    // Specify the table name explicitly to prevent Laravel from using 'curricula'
    protected $table = 'curriculums';

    protected $fillable = [
        'major',
        'subject_code',
        'subject_name',
        'year',
        'trimester',
        'units',
        'prerequisite',
    ];

    /**
     * Get curriculum by major and year
     */
    public static function getByMajorAndYear($major, $year)
    {
        return self::where('major', $major)
                  ->where('year', $year)
                  ->orderBy('trimester')
                  ->orderBy('subject_code')
                  ->get();
    }

    /**
     * Get curriculum by major
     */
    public static function getByMajor($major)
    {
        return self::where('major', $major)
                  ->orderBy('year')
                  ->orderBy('trimester')
                  ->orderBy('subject_code')
                  ->get();
    }
}
