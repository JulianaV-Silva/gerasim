@extends('layouts.auth')

@section('title', 'Entrar')
@section('side_title')
Bem-vindo<br>de volta.
@endsection
@section('side_text', 'Seus ambientes, simulados e o desempenho por tópico continuam de onde você parou.')

@section('content')
<form onsubmit="event.preventDefault();window.location='{{ route('dashboard') }}'">
  <h2>Entrar</h2>
  <div class="mb-3">
    <label class="form-label" for="login-email">Email</label>
    <div class="gs-input-icon"><x-icon name="mail" /><input id="login-email" type="email" class="form-control" value="arthur.silva@email.com"></div>
  </div>
  <div class="mb-2">
    <label class="form-label" for="login-pass">Senha</label>
    <div class="gs-input-icon"><x-icon name="lock" /><input id="login-pass" type="password" class="form-control" value="segredo123"></div>
  </div>
  <div class="d-flex justify-content-between align-items-center mb-4 small">
    <div class="form-check"><input class="form-check-input" type="checkbox" id="login-remember" checked><label class="form-check-label" for="login-remember">Lembrar de mim</label></div>
    <a href="{{ route('login') }}">Esqueci minha senha</a>
  </div>
  <button class="btn btn-gs w-100 py-2" type="submit">Entrar</button>
  <div class="gs-divider">ou</div>
  <button class="btn btn-google py-2" type="button">@include('layouts.partials.google-icon') Continuar com sua conta Google</button>
  <p class="text-center mt-4 mb-0 small">Ainda não tem conta? <a href="{{ route('register') }}" class="fw-semibold">Criar conta</a></p>
</form>
@endsection
