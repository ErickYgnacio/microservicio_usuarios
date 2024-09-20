<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';
    public $timestamps = false;
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'telefono',
        'correo_institucional',
        'contrasenia'
    ];

    protected $hidden = [
        'contrasenia'
    ];

    /* protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]; */

    # relaciones

    public function administrativo()
    {
        return $this->hasOne(Administrativo::class, 'id_usuario');
    }

    # mutadores

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setApellidoPaternoAttribute($value)
    {
        $this->attributes['apellido_paterno'] = strtoupper($value);
    }

    public function setApellidoMaternoAttribute($value)
    {
        $this->attributes['apellido_materno'] = strtoupper($value);
    }
}
