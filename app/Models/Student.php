<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'student_no', 'first_name', 'last_name', 'suffix', 'sex', 'dob', 'birthdate', 'gender',
        'email', 'contact_number', 'address', 'department_id', 'course_id', 'academic_year_id', 'year_level', 'status'
    ];

    protected $casts = [
        'dob' => 'date',
        'birthdate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
