<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $table = "labs";
    protected $primaryKey = "id";

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'lab_number', 'lab');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
