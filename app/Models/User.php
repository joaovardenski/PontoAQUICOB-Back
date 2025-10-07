<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

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
        'tipo_usuario' => 'string',
    ];

    public $timestamps = true;

    public function registrosPonto(): HasMany
    {
        return $this->hasMany(RegistroPonto::class, 'funcionario_id');
    }
}
