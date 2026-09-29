@extends('layout')

@section('titulo', 'Servidor')

@section('conteudo')
<h1>Endereço do servidor</h1>
<p class="legenda">O cliente conversa com qualquer servidor que siga o contrato /api/v1.</p>

<div class="painel">
    <form method="POST" action="{{ route('servidor.salvar') }}">
        @csrf
        <div class="campo">
            <label for="base_url">url base</label>
            <input type="text" id="base_url" name="base_url"
                value="{{ old('base_url', $baseUrl) }}"
                placeholder="http://localhost:8080/api/v1">
            @error('base_url') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>
        <small class="dica">o /api/v1 é fixo; troque só o ip e a porta</small>

        <div class="linha-botoes">
            <button type="submit">salvar</button>
        </div>
    </form>
</div>
@endsection