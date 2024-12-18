<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'course_id', 'student_id')
            ->withPivot('enrollment_date')
            ->withTimestamps();
    }
}
