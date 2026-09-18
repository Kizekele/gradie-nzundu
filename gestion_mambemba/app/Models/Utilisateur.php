<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'role',
        'telephone',
        'actif',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
