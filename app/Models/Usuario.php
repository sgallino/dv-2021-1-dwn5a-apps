<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

// Extendemos de la clase "User" del core de Laravel (no la de nuestra carpeta Models).
class Usuario extends User
{
//    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    /** @var string[] Indica qué propiedades del modelo NO deben serializar a array o JSON. */
    protected $hidden = ['password', 'remember_token'];
}
