<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'nome',
        'cpf',
        'cargo',
        'carga_horaria',
        'tipo_usuario',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'carga_horaria' => 'integer',
    ];

    public $timestamps = false;

    public function registrosPonto()
    {
        return $this->hasMany(RegistroPonto::class, 'funcionario_id');
    }
}
