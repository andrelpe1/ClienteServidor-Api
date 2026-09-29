<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Cliente') · api/v1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600&family=Fragment+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="topo">
        <a href="{{ session('token') ? route('perfil.mostrar') : route('login.tela') }}" class="marca">cliente<b>/</b>api-v1</a>
        <div class="conexao">
            <span class="ponto"></span>
            {{ session('api_base_url', config('services.api.base_url', 'não configurado')) }}
            <a href="{{ route('servidor.editar') }}">alterar</a>
        </div>
    </div>

    <nav class="trilha">
        @if (session('token'))
        <a href="{{ route('perfil.mostrar') }}" class="{{ request()->routeIs('perfil.mostrar') ? 'atual' : '' }}">perfil</a>
        @else
        <a href="{{ route('login.tela') }}" class="{{ request()->routeIs('login.tela') ? 'atual' : '' }}">entrar</a>
        <a href="{{ route('cadastro.tela') }}" class="{{ request()->routeIs('cadastro.tela') ? 'atual' : '' }}">cadastrar</a>
        @endif
    </nav>

    <main>
        @if (session('sucesso'))
        <p class="aviso aviso-sucesso">{{ session('sucesso') }}</p>
        @endif
        @if (session('aviso'))
        <p class="aviso aviso-info">{{ session('aviso') }}</p>
        @endif
        @if (session('erro'))
        <p class="aviso aviso-erro">{{ session('erro') }}</p>
        @endif

        @yield('conteudo')
    </main>
</body>

</html>