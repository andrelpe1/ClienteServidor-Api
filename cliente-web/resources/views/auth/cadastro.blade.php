@extends('layout')

@section('titulo', 'Criar conta')

@section('conteudo')
<h1>Criar conta</h1>
<p class="legenda">POST /users</p>

<div class="painel">
    <form method="POST" action="{{ route('cadastro.enviar') }}">
        @csrf

        <div class="campo">
            <label for="nome">nome</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}">
            @error('nome') <span class="erro-campo">{{ $message }}</span> @enderror
        </div>

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
            <button type="submit">cadastrar</button>
        </div>
    </form>
</div>

<p class="rodape-form">Já tem conta? <a class="acao-inline" href="{{ route('login.tela') }}">entrar</a></p>
@endsection