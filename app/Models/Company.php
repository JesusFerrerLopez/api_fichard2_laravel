<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasApiTokens;
    // Una compaía puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
