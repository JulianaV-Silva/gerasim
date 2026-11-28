@extends('layouts.exam')

@section('title', 'Resolver simulado')
@section('exam_title', 'Revisão da Prova')
@section('exit_url', route('ambientes.show'))

@section('content')
<div class="gs-exam" id="exam" data-finish-url="{{ route('tentativas.resultado') }}">
  <div class="d-flex justify-content-between align-items-end mb-2"><h1 class="h3 m-0">Revisão da Prova</h1><b class="text-primary tnum" id="ex-count">Questão 3 de 10</b></div>
  <div class="gs-steps mb-4" id="ex-steps"></div>
  <div class="row g-3">
    <div class="col-lg-8">
      {{-- @component: x-question (enunciado + alternativas) --}}
      <div class="gs-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2"><h2 class="h5 m-0" id="ex-qtitle">Questão 3</h2><span class="gs-chip" id="ex-qtopic">Triggers</span></div>
        <p class="gs-q-statement mb-4" id="ex-qtext"></p>
        <div class="gs-alts" id="ex-alts" role="radiogroup" aria-labelledby="ex-qtitle"></div>
        <div class="d-flex justify-content-between mt-4 gap-2">
          <button class="btn btn-gs-outline" id="ex-prev"><x-icon name="arrow-l" />Anterior</button>
          <button class="btn btn-gs" id="ex-next">Próxima<x-icon name="arrow-r" /></button>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="gs-card mb-3">
        <h2 class="gs-card-title mb-3" style="font-size:.9rem">Navegação das questões</h2>
        <div class="gs-qgrid mb-3" id="ex-grid"></div>
        <div class="gs-legend mb-3"><span><i style="background:#7d79e0"></i>Respondida</span><span><i style="border:1.5px solid #6c6ad8;background:#fff"></i>Questão atual</span><span><i style="background:var(--gs-soft)"></i>Em branco</span><span><i style="background:var(--gs-warn);border-radius:50%;width:8px;height:8px"></i>Marcada para revisar</span></div>
        <button class="btn btn-gs-outline w-100 btn-sm" id="ex-flag"><x-icon name="flag" class="ic-sm" />Marcar para revisar</button>
      </div>
      <div id="ex-finish-box" class="mb-3">
        <button class="btn btn-gs-dark w-100" id="ex-finish">Finalizar simulado</button>
      </div>
      <div class="gs-card">
        <h2 class="gs-card-title mb-2" style="font-size:.9rem">Sobre este simulado</h2>
        <div class="d-flex justify-content-between py-2 border-bottom small"><span class="text-muted-gs">Ambiente</span><b class="text-dark">Faculdade</b></div>
        <div class="d-flex justify-content-between py-2 border-bottom small"><span class="text-muted-gs">Questões</span><b class="text-dark">10</b></div>
        <div class="d-flex justify-content-between py-2 small"><span class="text-muted-gs">Tópicos</span><b class="text-dark text-end">Triggers, Estr. de Dados, Funções</b></div>
      </div>
    </div>
  </div>
</div>
@endsection
