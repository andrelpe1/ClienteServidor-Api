@extends('layout')

@section('titulo', 'Servidor')

@section('conteudo')
<p style="background:yellow;color:black;padding:.5rem">
    ID da sessão: {{ session()->getId() }} | api_base_url: {{ session('api_base_url') ?? 'VAZIO' }}
</p>

<h1>Endereço do servidor</h1>
<h1>Endereço do servidor</h1>
<p class="legenda">O cliente conversa com qualquer servidor que siga o contrato /api/v1.</p>

<div class="painel">
    <form method="POST" action="{{ route('servidor.salvar') }}">
        @csrf

        <div class="campo">
            <label for="ip">ip ou host</label>
            <input type="text" id="ip" name="ip" value="{{ old('ip', $ip) }}" placeholder="localhost">
            @error('ip') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>

        <div class="campo">
            <label for="porta">porta</label>
            <input type="text" id="porta" name="porta" value="{{ old('porta', $porta) }}" placeholder="8080">
            @error('porta') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>

        <small class="dica">resultado: http://{{ old('ip', $ip ?: 'ip') }}:{{ old('porta', $porta ?: 'porta') }}/api/v1</small>

        <div class="linha-botoes">
            <button type="submit">salvar</button>
        </div>
    </form>
</div>
@endsection