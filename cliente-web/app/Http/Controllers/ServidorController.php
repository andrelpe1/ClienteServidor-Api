<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ServidorController extends Controller
{
    public function editar(): View
    {
        [$ip, $porta] = $this->extrair(Session::get('api_base_url'));

        return view('servidor.editar', ['ip' => $ip, 'porta' => $porta]);
    }

    public function salvar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'ip'    => 'required|string|max:255',
            'porta' => 'required|integer|min:1|max:65535',
        ]);

        $url = "http://{$dados['ip']}:{$dados['porta']}/api/v1";

        Session::put('api_base_url', $url);

        return redirect()->route('servidor.editar')->with('sucesso', "Endereço salvo: {$url}");
    }


    private function extrair(?string $url): array
    {
        if (! $url) {
            return ['localhost', '8080'];
        }

        $partes = parse_url($url);

        return [$partes['host'] ?? 'localhost', (string) ($partes['port'] ?? '8080')];
    }
}
