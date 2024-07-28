<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nombre', 'correo', 'contrasena', 'token_secreto',
    ];

    protected $hidden = [
        'contrasena', 'token_secreto',
    ];
}