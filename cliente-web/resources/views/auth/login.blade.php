@extends('layout')

@section('titulo', 'Entrar')

@section('conteudo')
<h1>Entrar</h1>
<p class="legenda">POST /sessions</p>

<div class="painel">
    <form method="POST" action="{{ route('login.enviar') }}">
        @csrf

        <div class="campo">
            <label for="email">email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>

        <div class="campo">
            <label for="senha">senha</label>
            <input type="password" id="senha" name="senha">
            @error('senha') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>

        <div class="linha-botoes">
            <button type="submit">entrar</button>
        </div>
    </form>
</div>

<p class="rodape-form">Ainda não tem conta? <a class="acao-inline" href="{{ route('cadastro.tela') }}">cadastre-se</a></p>
@endsection