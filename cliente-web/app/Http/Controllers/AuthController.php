<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class AuthController extends Controller
{
    public function __construct(private ApiClient $api) {}

    public function telaCadastro(): View
    {
        return view('auth.cadastro');
    }

    public function cadastrar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome'  => 'required|string|max:50',
            'email' => 'required|email|max:30',
            'senha' => 'required|string|min:8|max:20',
        ]);

        [$status, $resposta] = $this->api->chamar('POST', '/users', $dados, comToken: false);

        if ($status === 201) {
            return redirect()->route('login.tela')
                ->with('sucesso', 'Conta criada. Agora é só entrar.');
        }

        if ($status === 409) {
            return redirect()->route('login.tela')
                ->with('aviso', 'Este e-mail já está cadastrado. Entre com sua senha.');
        }

        return back()->withInput()->with('erro', $resposta['mensagem'] ?? 'Não foi possível criar a conta.');
    }

    public function telaLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        [$status, $resposta] = $this->api->chamar('POST', '/sessions', $dados, comToken: false);

        if ($status !== 201) {
            return back()->withInput()->with('erro', $resposta['mensagem'] ?? 'Não foi possível entrar.');
        }

        Session::put('token', $resposta['token']);
        Session::put('sessao_id', $resposta['id']);
        Session::put('usuario_id', $resposta['usuario']['id']);

        return redirect()->route('perfil.mostrar');
    }



    public function logout(): \Illuminate\Http\RedirectResponse
    {
        $sessaoId = Session::get('sessao_id');

        if ($sessaoId) {
            $this->api->chamar('DELETE', "/sessions/{$sessaoId}");
        }

        Session::forget(['token', 'sessao_id', 'usuario_id']);

        return redirect()->route('login.tela')->with('sucesso', 'Sessão encerrada.');
    }
}
