<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (! ctype_digit($id)) {
            return response()->json(['mensagem' => 'O id informado não é um número inteiro válido.'], 400);
        }

        $user = User::find((int) $id);

        if (! $user) {
            return response()->json(['mensagem' => 'Usuário não encontrado.'], 404);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json(['mensagem' => 'Acesso negado.'], 403);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($erro = $this->checarDono($request, $id)) {
            return $erro;
        }

        $user = User::find((int) $id);


        $dados = Validator::make($request->all(), [
            'nome'  => 'required|string|max:50',
            'email' => 'required|string|email|max:30',
            'senha' => 'required|string|min:8|max:20',
        ])->validate();

        $emailEmUso = User::where('email', $dados['email'])
            ->where('id', '!=', $user->id)
            ->exists();

        if ($emailEmUso) {
            return response()->json(['mensagem' => 'E-mail já cadastrado.'], 409);
        }

        $user->update($dados);

        return new UserResource($user);
    }

    public function patch(Request $request, string $id)
    {
        if ($erro = $this->checarDono($request, $id)) {
            return $erro;
        }

        $user = User::find((int) $id);


        $dados = Validator::make($request->all(), [
            'nome'  => 'required_without_all:email,senha|string|max:50',
            'email' => 'required_without_all:nome,senha|string|email|max:30',
            'senha' => 'required_without_all:nome,email|string|min:8|max:20',
        ])->validate();

        if (isset($dados['email'])) {
            $emailEmUso = User::where('email', $dados['email'])
                ->where('id', '!=', $user->id)
                ->exists();

            if ($emailEmUso) {
                return response()->json(['mensagem' => 'E-mail já cadastrado.'], 409);
            }
        }

        $user->update($dados);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($erro = $this->checarDono($request, $id)) {
            return $erro;
        }

        $user = $request->user();

        $user->tokens()->delete();
        $user->delete();

        return response()->noContent();
    }

    private function checarDono(Request $request, string $id): ?JsonResponse
    {
        if (! ctype_digit($id)) {
            return response()->json(['mensagem' => 'O id informado não é um número inteiro válido.'], 400);
        }

        $user = User::find((int) $id);

        if (! $user) {
            return response()->json(['mensagem' => 'Usuário não encontrado.'], 404);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json(['mensagem' => 'Acesso negado.'], 403);
        }

        return null;
    }
}
