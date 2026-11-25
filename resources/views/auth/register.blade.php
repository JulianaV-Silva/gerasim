@extends('layouts.auth')

@section('title', 'Criar conta')
@section('side_title')
Estude com<br>o que você<br>já tem.
@endsection
@section('side_text', 'Envie seus materiais e receba simulados sob medida, com análise dos seus pontos fracos.')

@section('content')
<form onsubmit="event.preventDefault();window.location='{{ route('dashboard') }}'">
  <h2>Crie sua conta</h2>
  <div class="mb-3">
    <label class="form-label" for="reg-name">Nome completo</label>
    <div class="gs-input-icon"><x-icon name="user" /><input id="reg-name" class="form-control" placeholder="Seu nome"></div>
  </div>
  <div class="mb-3">
    <label class="form-label" for="reg-email">Email</label>
    <div class="gs-input-icon"><x-icon name="mail" /><input id="reg-email" type="email" class="form-control" placeholder="voce@email.com"></div>
  </div>
  <div class="mb-3">
    <label class="form-label" for="reg-pass">Senha</label>
    <div class="gs-input-icon"><x-icon name="lock" /><input id="reg-pass" type="password" class="form-control" placeholder="Mínimo de 8 caracteres"></div>
  </div>
  <div class="form-check mb-4 small">
    <input class="form-check-input" type="checkbox" id="reg-terms" checked>
    <label class="form-check-label" for="reg-terms">Li e aceito os <a href="{{ route('register') }}">termos de uso</a> e a <a href="{{ route('register') }}">política de privacidade</a></label>
  </div>
  <button class="btn btn-gs w-100 py-2" type="submit">Criar conta</button>
  <div class="gs-divider">ou</div>
  <button class="btn btn-google py-2" type="button">@include('layouts.partials.google-icon') Continuar com sua conta Google</button>
  <p class="text-center mt-4 mb-0 small">Já tem conta? <a href="{{ route('login') }}" class="fw-semibold">Entrar</a></p>
</form>
@endsection
