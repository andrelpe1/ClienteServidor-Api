<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Sessao;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $dados = $request->validated();
        if (User::where('email', $dados['email'])->exists()) {
            return response()->json(['mensagem' => 'E-mail já cadastrado.'], 409);
        }
        $user = User::create([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha' => Hash::make($dados['senha']),
        ]);
        return new UserResource($user)->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $dados = $request->validated();

        $user = User::where('email', $dados['email'])->first();

        if (! $user || ! Hash::check($dados['senha'], $user->senha)) {
            return response()->json(['mensagem' => 'E-mail ou senha inválidos'], 401);
        }

        $token = $user->createToken('sessao');

        $sessao = Sessao::create([
            'user_id'  => $user->id,
            'token_id' => $token->accessToken->id,
        ]);

        return response()->json([
            'id'      => $sessao->id,
            'token'   => $token->plainTextToken,
            'usuario' => (new UserResource($user))->resolve(),
        ], 201);
    }

    public function logout(Request $request, string $id)
    {
        $sessao = Sessao::find($id);

        if (! $sessao) {
            return response()->json(['mensagem' => 'Sessão não encontrada.'], 404);
        }

        if ($sessao->user_id !== $request->user()->id) {
            return response()->json(['mensagem' => 'Acesso negado.'], 403);
        }

        PersonalAccessToken::find($sessao->token_id)?->delete();
        $sessao->delete();

        return response()->noContent();
    }
}
