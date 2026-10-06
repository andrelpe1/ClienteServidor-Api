<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/monitor', [MonitorController::class, 'index'])->name('monitor');
Route::post('/monitor/limpar', [MonitorController::class, 'limpar'])->name('monitor.limpar');
