<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;

class Enquiry extends Model
{
    use HasFactory;

    protected $table = "enquiries";
    protected $primaryKey = "id";

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id' , 'id'); // 'course_id' is the foreign key in the Enquiry table
    }

    public function followups()
    {
        return $this->hasMany(Followup::class, 'enquiry_id', 'id');
    }


}
