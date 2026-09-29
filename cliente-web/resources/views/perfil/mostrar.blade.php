@extends('layout')

@section('titulo', 'Perfil')

@section('conteudo')
<h1>Meu perfil</h1>
<p class="legenda">GET /users/{id}</p>

<div class="painel">
    <dl class="dados">
        <div>
            <dt>nome</dt>
            <dd>{{ $usuario['nome'] }}</dd>
        </div>
        <div>
            <dt>email</dt>
            <dd>{{ $usuario['email'] }}</dd>
        </div>
    </dl>
</div>

<div class="painel">
    <h2>Editar dados</h2>

    <form method="POST" action="{{ route('perfil.editar') }}">
        @csrf

        <div class="campo">
            <label for="nome">nome</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $usuario['nome']) }}">
        </div>

        <div class="campo">
            <label for="email">email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $usuario['email']) }}">
        </div>

        <div class="campo">
            <label for="senha">nova senha</label>
            <input type="password" id="senha" name="senha">
        </div>

        <small class="dica">"salvar alterações" envia só o que foi preenchido · "salvar tudo" exige os três campos</small>

        <div class="linha-botoes">
            <button type="submit">salvar alterações</button>
            <button type="submit" formaction="{{ route('perfil.editarTudo') }}" class="sec">salvar tudo</button>
        </div>
    </form>
</div>

<hr class="separador">

<div class="linha-botoes">
    <form method="POST" action="{{ route('logout.enviar') }}">
        @csrf
        <button type="submit" class="sec">sair</button>
    </form>

    <form method="POST" action="{{ route('perfil.excluir') }}"
        onsubmit="return confirm('Excluir sua conta de forma definitiva? Isso encerra todas as suas sessões.');">
        @csrf
        <button type="submit" class="perigo">excluir minha conta</button>
    </form>
</div>
@endsection