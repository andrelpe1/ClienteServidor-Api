<?php

use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Route;

Route::get('/servidor', [ServidorController::class, 'editar'])->name('servidor.editar');
Route::post('/servidor', [ServidorController::class, 'salvar'])->name('servidor.salvar');
