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
        $atual = Session::get('api_base_url', config('services.api.base_url'));

        return view('servidor.editar', ['baseUrl' => $atual]);
    }

    public function salvar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'base_url' => 'required|string|max:255',
        ]);

        Session::put('api_base_url', rtrim($dados['base_url'], '/'));

        return redirect()->route('servidor.editar')->with('sucesso', 'Endereço salvo.');
    }
}
