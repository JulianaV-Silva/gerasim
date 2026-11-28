@extends('layouts.app')

@section('title', 'Banco de questões')

@section('content')
<div class="gs-page-head">
  <div>
    <div class="gs-eyebrow">Seu conteúdo</div>
    <h1 class="gs-page-title">Banco de questões</h1>
  </div>
  <a href="{{ route('simulados.create') }}" class="btn btn-gs-outline"><x-icon name="plus" />Gerar questões</a>
</div>

<form method="GET" action="{{ route('questoes.index') }}" class="gs-card mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label" for="qb-search">Buscar</label>
      <div class="gs-input-icon">
        <x-icon name="search" />
        <input id="qb-search" name="busca" value="{{ request('busca') }}" class="form-control" placeholder="Texto do enunciado" onchange="this.form.submit()">
      </div>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label" for="qb-disc">Disciplina</label>
      <select id="qb-disc" name="disciplina" class="form-select" onchange="this.form.submit()">
        <option value="">Todas</option>
        @foreach($ambientes as $amb)
          <option value="{{ $amb->id_ambiente }}" @selected(request('disciplina') == $amb->id_ambiente)>
            {{ $amb->nm_ambiente }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label" for="qb-topic">Tópico</label>
      <select id="qb-topic" name="topico" class="form-select" onchange="this.form.submit()">
        <option value="">Todos</option>
        @foreach($topicos as $top)
          <option value="{{ $top->id_topico }}" @selected(request('topico') == $top->id_topico)>
            {{ $top->nm_topico }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-2">
      <label class="form-label" for="qb-orig">Origem</label>
      <select id="qb-orig" name="origem" class="form-select" onchange="this.form.submit()">
        <option value="" @selected(!request('origem'))>Todas</option>
        <option value="ia" @selected(request('origem') === 'ia')>Gerada pela IA</option>
        <option value="manual" @selected(request('origem') === 'manual')>Criada por mim</option>
      </select>
    </div>
  </div>
</form>

<div class="gs-card">
  <div class="gs-card-head">
    <h2 class="gs-card-title">{{ $questoes->total() }} {{ $questoes->total() === 1 ? 'questão' : 'questões' }} em {{ $topicoSelecionado }}</h2>
    <span class="small text-muted-gs">Reutilizadas automaticamente ao gerar simulados</span>
  </div>

  @forelse($questoes as $q)
    <div class="gs-qbank-item">
      <div class="d-flex gap-2 flex-wrap">
        <span class="gs-chip">{{ $q->nm_topico }}</span>

        @if($q->id_simulado)
          <span class="gs-chip gs-chip-ai"><x-icon name="sparkles" class="ic-sm" />Gerada pela IA</span>
        @else
          <span class="gs-chip gs-chip-plain">Criada por mim</span>
        @endif

        @if($q->nm_ambiente)
          <span class="gs-chip gs-chip-plain">{{ $q->nm_ambiente }}</span>
        @endif
      </div>

      <p class="q">{{ $q->ds_enunciado }}</p>

      <ol>
        @foreach($alternativasPorQuestao[$q->id_questao] ?? [] as $alt)
          <li class="{{ $alt->fl_correta ? 'ok' : '' }}">
            {{ $alt->ds_alternativa }} @if($alt->fl_correta) ✓ @endif
          </li>
        @endforeach
      </ol>
    </div>
  @empty
    <p class="small text-muted-gs py-3 mb-0">Nenhuma questão encontrada para os filtros selecionados.</p>
  @endforelse

  @if($questoes->hasPages())
    <nav class="d-flex justify-content-center gap-1 mt-3" aria-label="Paginação">
      @foreach($questoes->getUrlRange(1, $questoes->lastPage()) as $pagina => $url)
        <a href="{{ $url }}" class="btn {{ $pagina == $questoes->currentPage() ? 'btn-gs-dark' : 'btn-gs-ghost' }} btn-icon btn-sm">
          {{ $pagina }}
        </a>
      @endforeach
    </nav>
  @endif
</div>
@endsection