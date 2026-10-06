<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Monitor de requisições</title>
    <meta http-equiv="refresh" content="3">
    <style>
        body {
            font-family: monospace;
            background: #0f1a1c;
            color: #e5e5e5;
            padding: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }

        th,
        td {
            border-bottom: 1px solid #2a3a3d;
            padding: .4rem .5rem;
            text-align: left;
            vertical-align: top;
        }

        th {
            color: #7fb3a8;
        }

        .m-GET {
            color: #5fb3a1;
        }

        .m-POST {
            color: #e2903f;
        }

        .m-PUT,
        .m-PATCH {
            color: #e2b23f;
        }

        .m-DELETE {
            color: #d1503a;
        }

        .ok {
            color: #5fb3a1;
        }

        .erro {
            color: #d1503a;
        }

        pre {
            white-space: pre-wrap;
            margin: 0;
            max-width: 28rem;
        }

        .barra {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .barra a {
            color: #e2903f;
            text-decoration: none;
        }

        .barra a:hover {
            text-decoration: underline;
        }

        .barra button {
            font-family: monospace;
            background: transparent;
            color: #d1503a;
            border: 1px solid #d1503a;
            border-radius: 3px;
            padding: .3rem .7rem;
            cursor: pointer;
        }

        .barra button:hover {
            background: #d1503a;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>Monitor de requisições — porta {{ request()->getPort() }}</h1>

    <div class="barra">
        <span>{{ $requisicoes->count() }} últimas chamadas</span>

        @if ($ordem === 'desc')
        <a href="{{ route('monitor', ['ordem' => 'asc']) }}">↑</a>
        @else
        <a href="{{ route('monitor', ['ordem' => 'desc']) }}">↓</a>
        @endif

        <form method="POST" action="{{ route('monitor.limpar') }}"
            onsubmit="return confirm('Apagar todo o histórico de requisições?');">
            @csrf
            <button type="submit">limpar histórico</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>quando</th>
                <th>método</th>
                <th>caminho</th>
                <th>ip</th>
                <th>corpo enviado</th>
                <th>status</th>
                <th>ms</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requisicoes as $r)
            <tr>
                <td>{{ $r->created_at->format('H:i:s') }}</td>
                <td class="m-{{ $r->metodo }}">{{ $r->metodo }}</td>
                <td>/{{ $r->caminho }}</td>
                <td>{{ $r->ip }}</td>
                <td>
                    <pre>{{ json_encode($r->corpo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </td>
                <td class="{{ $r->status < 400 ? 'ok' : 'erro' }}">{{ $r->status }}</td>
                <td>{{ $r->duracao_ms }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Nenhuma requisição registrada ainda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>