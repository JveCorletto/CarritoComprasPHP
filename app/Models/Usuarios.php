<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Usuarios'; // Nombre de tu tabla de usuarios
    protected $primaryKey = 'IdUsuario'; // Llave primaria de tu tabla
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Usuario',
        'Contrasenia',
        'IdRol',
        'IdEstado'
    ];

    protected $hidden = [
        'Contrasenia',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->Contrasenia;
    }
}
