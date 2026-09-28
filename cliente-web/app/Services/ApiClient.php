<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiClient
{
    private function baseUrl(): string
    {
        return Session::get('api_base_url', config('services.api.base_url'));
    }

    public function chamar(string $metodo, string $caminho, array $corpo = [], bool $comToken = true): array
    {
        $requisicao = Http::acceptJson();

        if ($comToken && Session::has('token')) {
            $requisicao = $requisicao->withToken(Session::get('token'));
        }

        try {
            $resposta = $requisicao->send($metodo, $this->baseUrl() . $caminho, [
                'json' => $corpo,
            ]);
        } catch (ConnectionException) {
            return [0, ['mensagem' => 'Não foi possível conectar ao servidor. Confira o endereço configurado.']];
        }

        return [$resposta->status(), $resposta->json() ?? []];
    }
}
