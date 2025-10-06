<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPonto extends Model
{
    use HasFactory;

    protected $table = 'registros_ponto';

    protected $fillable = [
        'funcionario_id',
        'datahora',
        'tipo',
    ];

    public $timestamps = false;

    public function funcionario()
    {
        return $this->belongsTo(User::class, 'funcionario_id');
    }
}
