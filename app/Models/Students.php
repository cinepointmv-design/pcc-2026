<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $table = "students";
    protected $primaryKey = "id";

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class, 'student_id', 'id');
    }

    public function fees()
    {
        return $this->hasMany(StudentFees::class, 'student_id', 'id');
    }

    public function courses()
    {
        return $this->belongsToMany(Courses::class, 'student_course', 'student_id', 'course_id');
    }


}
