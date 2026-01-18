<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;
    protected $table = "student_course";
    protected $primaryKey = "id";

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

 
}
