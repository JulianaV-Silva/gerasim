@extends('layouts.app')

@section('title', 'Faculdade')

@section('content')
<div class="gs-page-head">
  <div class="d-flex gap-3 align-items-center">
    <div class="gs-icon-tile t-indigo" style="width:56px;height:56px;border-radius:16px"><svg class="ic" style="width:26px;height:26px"><use href="#i-grad"/></svg></div>
    <div><div class="gs-eyebrow"><a href="{{ route('ambientes.index') }}">Meus ambientes</a> / Faculdade</div><h1 class="gs-page-title">Faculdade</h1></div>
  </div>
  <div class="d-flex gap-2 flex-wrap"><a href="{{ route('ambientes.create') }}" class="btn btn-gs-outline"><x-icon name="pencil" />Editar</a><a href="{{ route('simulados.create') }}" class="btn btn-gs"><x-icon name="plus" />Novo simulado</a></div>
</div>
<div class="row g-3 mb-3">
  <div class="col-6 col-lg-3"><div class="gs-kpi bg-white"><div class="lbl">Domínio</div><div class="val">72%</div></div></div>
  <div class="col-6 col-lg-3"><div class="gs-kpi bg-white"><div class="lbl">Tópicos</div><div class="val">8</div></div></div>
  <div class="col-6 col-lg-3"><div class="gs-kpi bg-white"><div class="lbl">Simulados</div><div class="val">4</div></div></div>
  <div class="col-6 col-lg-3"><div class="gs-kpi bg-white"><div class="lbl">Questões disponíveis</div><div class="val">47</div></div></div>
</div>
<div class="row g-3">
  <div class="col-xl-7">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Simulados</h2><a href="{{ route('simulados.create') }}" class="small fw-semibold">+ Criar simulado</a></div>
      {{-- @component: x-exam-row --}}
      <div class="d-flex flex-column gap-2">
        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:#fafaff">
          <div class="gs-icon-tile t-soft"><x-icon name="clipboard" /></div>
          <div class="flex-grow-1 min-w-0"><div class="fw-semibold text-dark">Revisão da Prova 1</div><div class="small text-muted-gs">10 questões · Triggers, Estrutura de Dados, Funções</div></div>
          <div class="text-end d-none d-sm-block"><div class="gs-score">8/10</div><div class="small text-muted-gs">20/11</div></div>
          <a href="{{ route('simulados.resolver') }}" class="btn btn-gs-outline btn-sm">Refazer</a>
        </div>
        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:#fafaff">
          <div class="gs-icon-tile t-soft"><x-icon name="clipboard" /></div>
          <div class="flex-grow-1 min-w-0"><div class="fw-semibold text-dark">Banco de Dados — Triggers</div><div class="small text-muted-gs">10 questões · Triggers</div></div>
          <div class="text-end d-none d-sm-block"><div class="gs-score">7/10</div><div class="small text-muted-gs">18/11</div></div>
          <a href="{{ route('simulados.resolver') }}" class="btn btn-gs-outline btn-sm">Refazer</a>
        </div>
        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:#fafaff">
          <div class="gs-icon-tile t-soft"><x-icon name="clipboard" /></div>
          <div class="flex-grow-1 min-w-0"><div class="fw-semibold text-dark">Estruturas lineares</div><div class="small text-muted-gs">15 questões · Pilhas e filas, Listas</div></div>
          <div class="text-end d-none d-sm-block"><span class="gs-chip gs-chip-plain">Não iniciado</span></div>
          <a href="{{ route('simulados.resolver') }}" class="btn btn-gs btn-sm">Iniciar</a>
        </div>
        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:#fafaff">
          <div class="gs-icon-tile t-soft"><x-icon name="clipboard" /></div>
          <div class="flex-grow-1 min-w-0"><div class="fw-semibold text-dark">Revisão de Funções</div><div class="small text-muted-gs">8 questões · Funções PostgreSQL</div></div>
          <div class="text-end d-none d-sm-block"><div class="gs-score">5/8</div><div class="small text-muted-gs">08/11</div></div>
          <a href="{{ route('simulados.resolver') }}" class="btn btn-gs-outline btn-sm">Refazer</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-5">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Tópicos do ambiente</h2><a href="{{ route('ambientes.create') }}" class="small fw-semibold">Gerenciar</a></div>
      <p class="gs-section-label small text-uppercase text-muted-gs" style="letter-spacing:.06em;font-size:.72rem">Banco de Dados</p>
      <x-topic-progress :value="100" display="100%">Triggers</x-topic-progress>
      <x-topic-progress :value="50" display="50%">Funções PostgreSQL</x-topic-progress>
      <p class="gs-section-label small text-uppercase text-muted-gs mt-3" style="letter-spacing:.06em;font-size:.72rem">Estrutura de Dados</p>
      <x-topic-progress :value="84" display="84%">Pilhas e filas</x-topic-progress>
      <x-topic-progress :value="66" display="66%">Listas encadeadas</x-topic-progress>
      <x-topic-progress :value="38" display="38%" weak>Árvores binárias</x-topic-progress>
      <x-alert type="info" icon="sparkles" class="mt-3"><strong>Procedures</strong> tem 0 questões no banco. Ao incluir esse tópico num simulado, a IA gera as questões que faltarem.</x-alert>
    </div>
  </div>
</div>
@endsection
