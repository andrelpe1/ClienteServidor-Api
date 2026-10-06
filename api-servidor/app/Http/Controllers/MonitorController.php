<?php

namespace App\Http\Controllers;

use App\Models\RequisicaoLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonitorController extends Controller
{
    public function index(Request $request): View
    {
        $ordem = $request->query('ordem') === 'asc' ? 'asc' : 'desc';

        $requisicoes = RequisicaoLog::orderBy('created_at', $ordem)
            ->limit(100)
            ->get();

        return view('monitor', [
            'requisicoes' => $requisicoes,
            'ordem'       => $ordem,
        ]);
    }

    public function limpar(): RedirectResponse
    {
        RequisicaoLog::truncate();

        return redirect()->route('monitor');
    }
}
