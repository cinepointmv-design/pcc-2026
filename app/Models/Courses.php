<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $table = "courses";
    protected $primaryKey = "id";

    public function students()
    {
        return $this->belongsToMany(Students::class, 'student_course', 'course_id', 'student_id');
    }
    
    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class, 'course_id');
    }

    public function batches()
    {
        return $this->studentCourses()->pluck('batch')->unique();
    }

    public function lab()
    {
        return $this->hasOne(Lab::class, 'id', 'lab_number');
    }
    
    public function labs()
{
    return $this->belongsTo(Lab::class, 'lab_number', 'id');
}
   
}
