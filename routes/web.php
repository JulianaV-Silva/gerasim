<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SimuladoController;
use App\Http\Controllers\QuestaoController;

Route::view('/', 'home')->name('home');

Route::view('/login', 'auth.login')->name('login');

Route::view('/cadastro', 'auth.register')->name('register');

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::get('/ambientes', [AmbienteController::class, 'index'])->name('ambientes.index');
Route::get('/ambientes/criar', [AmbienteController::class, 'create'])->name('ambientes.create');
Route::post('/ambientes', [AmbienteController::class, 'store'])->name('ambientes.store');
Route::delete('/ambientes/{id}/cancelar', [AmbienteController::class, 'cancelarRascunho'])->name('ambientes.cancelar');
Route::delete('/ambientes/{id}', [AmbienteController::class, 'destroy'])->name('ambientes.destroy');

Route::view('/disciplinas', 'disciplinas.index')->name('disciplinas.index');
Route::view('/disciplinas/criar', 'disciplinas.create')->name('disciplinas.create');

Route::get('/materiais/enviar', [MaterialController::class, 'create'])->name('materiais.create');
Route::post('/materiais', [MaterialController::class, 'store'])->name('materiais.store');
Route::get('/materiais/{id}/topicos', [MaterialController::class, 'topicos'])->name('materiais.topicos');
Route::post('/materiais/{id}/topicos', [MaterialController::class, 'salvarTopicos'])->name('materiais.salvarTopicos');

Route::get('/questoes', [QuestaoController::class, 'index'])->name('questoes.index');

Route::get('/simulados/criar', [SimuladoController::class, 'create'])->name('simulados.create');
Route::post('/simulados', [SimuladoController::class, 'store'])->name('simulados.store');
Route::get('/simulados/{id}/resolver', [SimuladoController::class, 'resolver'])->name('simulados.resolver');

Route::view('/tentativas/exemplo/resultado', 'tentativas.resultado')->name('tentativas.resultado');
Route::view('/tentativas/exemplo', 'tentativas.show')->name('tentativas.show');
Route::view('/historico', 'tentativas.index')->name('tentativas.index');