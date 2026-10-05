<?php

use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;

Route::get('/', function () {
    return redirect()->route(session('token') ? 'perfil.mostrar' : 'login.tela');
});

Route::get('/servidor', [ServidorController::class, 'editar'])->name('servidor.editar');
Route::post('/servidor', [ServidorController::class, 'salvar'])->name('servidor.salvar');

Route::get('/cadastro', [AuthController::class, 'telaCadastro'])->name('cadastro.tela');
Route::post('/cadastro', [AuthController::class, 'cadastrar'])->name('cadastro.enviar');

Route::get('/login', [AuthController::class, 'telaLogin'])->name('login.tela');
Route::post('/login', [AuthController::class, 'login'])->name('login.enviar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.enviar');

Route::middleware('logado')->group(function () {
    Route::get('/perfil', [PerfilController::class, 'mostrar'])->name('perfil.mostrar');
    Route::post('/perfil/editar', [PerfilController::class, 'editarSalvar'])->name('perfil.editar');
    Route::post('/perfil/editar-tudo', [PerfilController::class, 'editarTudoSalvar'])->name('perfil.editarTudo');
    Route::post('/perfil/excluir', [PerfilController::class, 'excluir'])->name('perfil.excluir');
});
