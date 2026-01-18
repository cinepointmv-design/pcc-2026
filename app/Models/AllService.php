<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllService extends Model
{
    use HasFactory;

    protected $table = "allservice";
    protected $primaryKey = "id";

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
