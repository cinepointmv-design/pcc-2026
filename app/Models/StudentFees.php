<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFees extends Model
{
    use HasFactory;

    protected $table = "fees";
    protected $primaryKey = "id";
    
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }

    public function studentCourse()
    {
        return $this->hasMany(StudentCourse::class, 'student_id', 'student_id');
    }
    
}
