<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GarantirLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('token')) {
            return redirect()->route('login.tela')
                ->with('aviso', 'Entre para continuar.');
        }

        return $next($request);
    }
}
