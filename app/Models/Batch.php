<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = "batches";
    protected $primaryKey = "id";

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
