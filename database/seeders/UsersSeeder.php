<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        User::updateOrCreate(
            ['cpf' => '071.340.919-37'],
            [
                'nome' => 'Administrador',
                'cargo' => 'Admin',
                'carga_horaria' => 8,
                'tipo_usuario' => 'admin',
                'password' => Hash::make('admin1234'),
            ]
        );

        // Funcionário 1
        User::updateOrCreate(
            ['cpf' => '174.244.710-40'],
            [
                'nome' => 'João Silva',
                'cargo' => 'Operador de Máquina',
                'carga_horaria' => 8,
                'tipo_usuario' => 'funcionario',
                'password' => Hash::make('func12345'),
            ]
        );

        // Funcionário 2
        User::updateOrCreate(
            ['cpf' => '142.811.680-01'],
            [
                'nome' => 'Maria Oliveira',
                'cargo' => 'Assistente Administrativo',
                'carga_horaria' => 8,
                'tipo_usuario' => 'funcionario',
                'password' => Hash::make('func12345'),
            ]
        );
    }
}
