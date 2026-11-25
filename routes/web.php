<?php

use Illuminate\Support\Facades\Route;

/*
 | Rotas de visualização do front-end do GeraSim (somente telas, sem lógica).
 | Conforme os controllers forem criados, troque cada Route::view por
 | Route::get(..., [Controller::class, 'metodo']) mantendo o mesmo ->name().
 | As rotas com 'exemplo' vão receber o id do registro, ex.: /ambientes/{ambiente}.
 */


Route::view('/', 'home')->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/cadastro', 'auth.register')->name('register');
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::view('/ambientes', 'ambientes.index')->name('ambientes.index');
Route::view('/ambientes/criar', 'ambientes.create')->name('ambientes.create');
Route::view('/ambientes/exemplo', 'ambientes.show')->name('ambientes.show');
Route::view('/disciplinas', 'disciplinas.index')->name('disciplinas.index');
Route::view('/disciplinas/criar', 'disciplinas.create')->name('disciplinas.create');
Route::view('/materiais/enviar', 'materiais.create')->name('materiais.create');
Route::view('/materiais/exemplo/topicos', 'materiais.topicos')->name('materiais.topicos');
Route::view('/questoes', 'questoes.index')->name('questoes.index');
Route::view('/simulados/criar', 'simulados.create')->name('simulados.create');
Route::view('/simulados/exemplo/resolver', 'simulados.resolver')->name('simulados.resolver');
Route::view('/tentativas/exemplo/resultado', 'tentativas.resultado')->name('tentativas.resultado');
Route::view('/historico', 'tentativas.index')->name('tentativas.index');
Route::view('/tentativas/exemplo', 'tentativas.show')->name('tentativas.show');
