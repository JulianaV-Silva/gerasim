@extends('layouts.app')

@section('title', 'Meus ambientes')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Olá, Arthur. Vamos praticar?</div><h1 class="gs-page-title">Meus ambientes de estudo</h1></div>
  <a href="{{ route('ambientes.create') }}" class="btn btn-gs"><x-icon name="plus" />Novo ambiente</a>
</div>

@if(session('sucesso'))
  <div class="alert alert-success mb-3">{{ session('sucesso') }}</div>
@endif

@php
  $coresIcone = [
    'grad'     => 't-indigo',
    'pencil'   => 't-blue',
    'network'  => 't-violet',
    'database' => '',
    'book'     => 't-soft',
  ];
@endphp

<div class="row g-3">
  @foreach($ambientes as $amb)
    @php
      $icone = $icones[$amb->id_ambiente] ?? 'grad';
    @endphp

    <div class="col-md-6 col-xl-4">
      <div class="gs-card gs-env position-relative">
        <div class="d-flex justify-content-between align-items-start">
          <div class="gs-icon-tile {{ $coresIcone[$icone] ?? 't-indigo' }}">
            <x-icon :name="$icone" class="ic-lg" />
          </div>

          <div class="dropdown">
            <button type="button" class="btn btn-gs-ghost btn-icon" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Opções do ambiente">
              <x-icon name="dots" />
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
              <li>
                <form action="{{ route('ambientes.destroy', ['id' => $amb->id_ambiente]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este ambiente e seus materiais?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item text-danger small">Excluir ambiente</button>
                </form>
              </li>
            </ul>
          </div>
        </div>

        <a href="{{ route('materiais.create', ['ambiente' => $amb->id_ambiente]) }}" class="text-reset text-decoration-none d-block mt-2">
          <h3>{{ $amb->nm_ambiente }}</h3>
          <p>{{ $amb->ds_descricao ?: 'Sem descrição informada.' }}</p>
          <div class="d-flex gap-1 flex-wrap mb-3">
            <span class="gs-chip gs-chip-plain">{{ $amb->qtd_materiais }} materiais</span>
            <span class="gs-chip gs-chip-plain">{{ $amb->qtd_simulados }} simulados</span>
          </div>
          <div class="gs-env-foot">
            <span>Clique para enviar material</span>
            <span class="gs-go"><x-icon name="arrow-r" class="ic-sm" /></span>
          </div>
        </a>
      </div>
    </div>
  @endforeach

  <div class="col-md-6 col-xl-4">
    <a href="{{ route('ambientes.create') }}" class="gs-card gs-new text-reset">
      <span class="plus"><x-icon name="plus" class="ic-lg" /></span>
      <b class="text-dark">Novo ambiente</b>
      <span class="small" style="max-width:16rem">Reúna tópicos de disciplinas diferentes e gere seu primeiro simulado.</span>
    </a>
  </div>
</div>
@endsection