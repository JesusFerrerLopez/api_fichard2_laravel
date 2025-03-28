<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    /** @use HasFactory<\Database\Factories\TimeFactory> */
    use HasFactory;

    // Evitar que se guarden los campos created_at y updated_at
    public $timestamps = false;

    // Relación con usuarios, un usuario puede tener muchos tiempos
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
