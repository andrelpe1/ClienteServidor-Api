<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Configurar servidor</title>
</head>

<body>
    <h1>Endereço do servidor</h1>

    @if (session('sucesso'))
    <p style="color: green">{{ session('sucesso') }}</p>
    @endif

    @error('base_url')
    <p style="color: red">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('servidor.salvar') }}">
        @csrf
        <label for="base_url">URL base (ex.: http://localhost:8080/api/v1)</label><br>
        <input type="text" id="base_url" name="base_url" value="{{ old('base_url', $baseUrl) }}" style="width: 400px">
        <button type="submit">Salvar</button>
    </form>
</body>

</html>