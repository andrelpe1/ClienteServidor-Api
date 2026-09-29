<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function __construct(private ApiClient $api) {}

    public function mostrar(): View|RedirectResponse
    {
        $id = Session::get('usuario_id');

        [$status, $dados] = $this->api->chamar('GET', "/users/{$id}");
        if ($status === 401) {
            Session::forget(['token', 'sessao_id', 'usuario_id']);
            return redirect()->route('login.tela')->with('aviso', 'Sua sessão expirou. Entre novamente.');
        }

        if ($status !== 200) {
            return redirect()->route('login.tela')->with('erro', $dados['mensagem'] ?? 'Erro ao carregar o perfil.');
        }

        return view('perfil.mostrar', ['usuario' => $dados]);
    }

    public function editarSalvar(Request $request): RedirectResponse
    {
        $id = Session::get('usuario_id');

        $dados = array_filter([
            'nome'  => $request->input('nome'),
            'email' => $request->input('email'),
            'senha' => $request->input('senha'),
        ], fn($valor) => filled($valor));

        if (empty($dados)) {
            return back()->with('erro', 'Preencha ao menos um campo.');
        }

        [$status, $resposta] = $this->api->chamar('PATCH', "/users/{$id}", $dados);

        return $this->tratarRespostaEdicao($status, $resposta);
    }

    public function editarTudoSalvar(Request $request): RedirectResponse
    {
        $id = Session::get('usuario_id');

        $dados = $request->validate([
            'nome'  => 'required|string',
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        [$status, $resposta] = $this->api->chamar('PUT', "/users/{$id}", $dados);

        return $this->tratarRespostaEdicao($status, $resposta);
    }

    private function tratarRespostaEdicao(int $status, array $resposta): RedirectResponse
    {
        if ($status === 200) {
            return redirect()->route('perfil.mostrar')->with('sucesso', 'Dados atualizados.');
        }

        if ($status === 401) {
            Session::forget(['token', 'sessao_id', 'usuario_id']);
            return redirect()->route('login.tela')->with('aviso', 'Sua sessão expirou. Entre novamente.');
        }

        return back()->with('erro', $resposta['mensagem'] ?? 'Não foi possível salvar.');
    }

    public function excluir(): RedirectResponse
    {
        $id = Session::get('usuario_id');

        [$status, $resposta] = $this->api->chamar('DELETE', "/users/{$id}");

        if ($status === 204) {
            Session::forget(['token', 'sessao_id', 'usuario_id']);
            return redirect()->route('login.tela')->with('sucesso', 'Conta excluída.');
        }

        return back()->with('erro', $resposta['mensagem'] ?? 'Não foi possível excluir a conta.');
    }
}
