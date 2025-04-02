<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'code'];

    // Un usuario puede tener muchos tiempos
    public function times()
    {
        return $this->hasMany(Time::class);
    }

    // Devuelve el último tiempo registrado por el usuario
    public function lastAction(): HasOne
{
    return $this->hasOne(Time::class, 'user_id')
        ->latestOfMany('datetime')
        ->select(['times.id', 'times.user_id', 'times.datetime', 'times.type', 'times.pause_reason']);
}
}
