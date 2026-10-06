<?php

namespace App\Http\Middleware;

use App\Models\RequisicaoLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrarRequisicao
{
    public function handle(Request $request, Closure $next): Response
    {
        $inicio = microtime(true);

        $resposta = $next($request);

        $corpo = $request->all();
        unset($corpo['senha']);

        RequisicaoLog::create([
            'metodo'     => $request->method(),
            'caminho'    => $request->path(),
            'ip'         => $request->ip(),
            'corpo'      => $corpo,
            'status'     => $resposta->getStatusCode(),
            'resposta'   => json_decode($resposta->getContent(), true),
            'duracao_ms' => (int) ((microtime(true) - $inicio) * 1000),
        ]);

        return $resposta;
    }
}
