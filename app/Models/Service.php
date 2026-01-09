<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $primaryKey = "id";

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'username', 'username');
    }

}
