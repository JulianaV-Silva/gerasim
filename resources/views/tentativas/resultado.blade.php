@extends('layouts.app')

@section('title', 'Resultado')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow"><a href="{{ route('ambientes.show') }}">Faculdade</a> / Revisão da Prova</div><h1 class="gs-page-title">Resultado</h1></div>
  <div class="d-flex gap-2 flex-wrap"><a href="{{ route('tentativas.show') }}" class="btn btn-gs-outline"><x-icon name="eye" />Ver respostas</a><a href="{{ route('simulados.create') }}" class="btn btn-gs"><x-icon name="refresh" />Refazer o que errei</a></div>
</div>
<div class="row g-3">
  <div class="col-lg-5">
    <div class="gs-card h-100">
      <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
        <div class="gs-ring" style="--p:80"><div><div><b class="tnum">8/10</b><small>acertos</small></div></div></div>
        <div><div class="gs-chip gs-chip-ok mb-2">Nota 8,0</div><h2 class="h5 mb-1">Bom resultado, Arthur.</h2><p class="small text-muted-gs mb-0">Você foi 10 pontos melhor que a sua última tentativa neste ambiente.</p></div>
      </div>
      <div class="row g-2">
        <div class="col-4"><div class="gs-kpi"><div class="lbl">Acertos</div><div class="val" style="color:var(--gs-ok)">8</div></div></div>
        <div class="col-4"><div class="gs-kpi"><div class="lbl">Erros</div><div class="val" style="color:var(--gs-bad)">2</div></div></div>
        <div class="col-4"><div class="gs-kpi"><div class="lbl">Tempo</div><div class="val">14:22</div></div></div>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Desempenho por tópico</h2></div>
      <x-topic-progress :value="100" display="100%">Triggers <span class="small text-muted-gs">5/5</span></x-topic-progress>
      <x-topic-progress :value="67" display="67%">Estrutura de Dados <span class="small text-muted-gs">2/3</span></x-topic-progress>
      <x-topic-progress :value="50" display="50%" weak>Funções <span class="small text-muted-gs">1/2</span></x-topic-progress>
      <x-alert type="warn" icon="alert" class="mt-3"><strong>Mais dificuldade em Funções</strong> (50%) e <strong>Estrutura de Dados</strong> (67%). Errou sobre IMMUTABLE e sobre percurso em ordem.</x-alert>
    </div>
  </div>
</div>
@endsection
