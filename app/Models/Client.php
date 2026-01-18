<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Client extends Model implements Authenticatable
{
    use HasFactory;
    use AuthenticatableTrait;

    protected $table = "clients";
    protected $primaryKey = "id";

    public function services()
    {
        return $this->hasMany('App\Models\Service', 'username', 'username');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\ClientPayments', 'client_id', 'id');
    }

}
