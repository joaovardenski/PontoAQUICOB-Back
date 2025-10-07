<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Exibe a lista de funcionários (somente tipo_usuario = funcionario)
     */
    public function index()
    {
        $funcionarios = User::where('tipo_usuario', 'funcionario')->get();

        return response()->json($funcionarios);
    }

    /**
     * Cria um novo funcionário com senha baseada no CPF
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|max:14|unique:users,cpf',
            'cargo' => 'nullable|string|max:50',
            'carga_horaria' => 'nullable|integer|min:1|max:24',
        ]);

        // Gerar senha segura (mínimo 8 caracteres)
        // Pega os últimos 4 dígitos do CPF + 4 caracteres aleatórios
        $cpfNumeros = preg_replace('/[^0-9]/', '', $request->cpf);
        $ultimos4 = substr($cpfNumeros, -4);
        $senha = $ultimos4 . Str::random(6);

        $user = User::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'cargo' => $request->cargo,
            'carga_horaria' => $request->carga_horaria,
            'tipo_usuario' => 'funcionario',
            'password' => Hash::make($senha),
        ]);

        return response()->json([
            'message' => 'Funcionário criado com sucesso!',
            'usuario' => $user,
            'senha_inicial' => $senha,
        ], 201);
    }


    /**
     * Exibe um funcionário específico
     */
    public function show($id)
    {
        $user = User::where('tipo_usuario', 'funcionario')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Atualiza dados do funcionário
     */
    public function update(Request $request, $id)
    {
        $user = User::where('tipo_usuario', 'funcionario')->findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => [
                'required',
                'string',
                'max:14',
                Rule::unique('users', 'cpf')->ignore($user->id),
            ],
            'cargo' => 'nullable|string|max:50',
            'carga_horaria' => 'nullable|integer|min:1|max:24',
        ]);

        $user->update($request->only(['nome', 'cpf', 'cargo', 'carga_horaria']));

        return response()->json(['message' => 'Funcionário atualizado com sucesso!', 'usuario' => $user]);
    }

    /**
     * Remove um funcionário
     */
    public function destroy($id)
    {
        $user = User::where('tipo_usuario', 'funcionario')->findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Funcionário removido com sucesso!']);
    }
}
