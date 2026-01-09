<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    protected $table = "followup";
    protected $primaryKey = "id";

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id', 'id');
    }
}
