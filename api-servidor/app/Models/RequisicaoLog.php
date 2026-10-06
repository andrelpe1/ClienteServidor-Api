<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisicaoLog extends Model
{
    protected $table = 'requisicoes_log';

    protected $fillable = [
        'metodo',
        'caminho',
        'ip',
        'corpo',
        'status',
        'resposta',
        'duracao_ms',
    ];

    protected $casts = [
        'corpo'    => 'array',
        'resposta' => 'array',
    ];
}
