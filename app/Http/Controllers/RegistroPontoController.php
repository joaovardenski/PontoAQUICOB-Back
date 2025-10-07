<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistroPonto;

class RegistroPontoController extends Controller
{
    public function registrar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,pausa,saida',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $registro = RegistroPonto::create([
            'funcionario_id' => $user->id,
            'datahora' => now(),
            'tipo' => $request->tipo,
        ]);

        return response()->json([
            'message' => 'Ponto registrado com sucesso!',
            'registro' => $registro,
        ], 201);
    }

    public function pontosFuncionario(Request $request, $funcionarioId)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);


        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $pontos = RegistroPonto::where('funcionario_id', $funcionarioId)
            ->whereBetween('datahora', [$request->data_inicio, $request->data_fim])
            ->orderBy('datahora', 'asc')
            ->get();

        return response()->json($pontos);
    }

    public function meusPontosDoDia(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        // data enviada via query ou hoje por padrão
        $data = $request->query('data', now()->toDateString());

        $inicio = $data . ' 00:00:00';
        $fim = $data . ' 23:59:59';

        $pontos = RegistroPonto::where('funcionario_id', $user->id)
            ->whereBetween('datahora', [$inicio, $fim])
            ->orderBy('datahora', 'asc')
            ->get();

        return response()->json($pontos);
    }

}
