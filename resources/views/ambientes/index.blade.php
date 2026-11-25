@extends('layouts.app')

@section('title', 'Meus ambientes')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Olá, Arthur. Vamos praticar?</div><h1 class="gs-page-title">Meus ambientes de estudo</h1></div>
  <a href="{{ route('ambientes.create') }}" class="btn btn-gs"><x-icon name="plus" />Novo ambiente</a>
</div>
<div class="gs-pills mb-3" role="group" aria-label="Filtrar ambientes"><button class="active">Todos</button><button>Em andamento</button><button>Concluídos</button></div>
<div class="row g-3">
  {{-- @component: x-environment-card --}}
  <div class="col-md-6 col-xl-4"><a href="{{ route('ambientes.show') }}" class="gs-card gs-env text-reset">
    <div class="d-flex justify-content-between"><div class="gs-icon-tile t-indigo"><x-icon name="grad" class="ic-lg" /></div><span class="btn btn-gs-ghost btn-icon"><x-icon name="dots" /></span></div>
    <h3>Faculdade</h3><p>Revisão para a prova do 4º período: triggers, funções no PostgreSQL e estruturas de dados.</p>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip">Banco de Dados</span><span class="gs-chip">Estrutura de Dados</span></div>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip gs-chip-plain">8 tópicos</span><span class="gs-chip gs-chip-plain">4 simulados</span></div>
    <div><div class="d-flex justify-content-between small mb-1"><span class="text-muted-gs">Domínio do conteúdo</span><b class="text-dark tnum">72%</b></div><div class="gs-bar"><span style="width:72%"></span></div></div>
    <div class="gs-env-foot"><span>Último simulado há 4 dias</span><span class="gs-go"><x-icon name="arrow-r" class="ic-sm" /></span></div>
  </a></div>
  <div class="col-md-6 col-xl-4"><a href="{{ route('ambientes.show') }}" class="gs-card gs-env text-reset">
    <div class="d-flex justify-content-between"><div class="gs-icon-tile t-blue"><x-icon name="pencil" class="ic-lg" /></div><span class="btn btn-gs-ghost btn-icon"><x-icon name="dots" /></span></div>
    <h3>Vestibular</h3><p>Preparação para o ENEM com foco em interpretação de texto, redação e funções.</p>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip">Português</span><span class="gs-chip">Redação</span><span class="gs-chip">Matemática</span></div>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip gs-chip-plain">11 tópicos</span><span class="gs-chip gs-chip-plain">3 simulados</span></div>
    <div><div class="d-flex justify-content-between small mb-1"><span class="text-muted-gs">Domínio do conteúdo</span><b class="text-dark tnum">58%</b></div><div class="gs-bar"><span style="width:58%"></span></div></div>
    <div class="gs-env-foot"><span>Último simulado há 9 dias</span><span class="gs-go"><x-icon name="arrow-r" class="ic-sm" /></span></div>
  </a></div>
  <div class="col-md-6 col-xl-4"><a href="{{ route('ambientes.show') }}" class="gs-card gs-env text-reset">
    <div class="d-flex justify-content-between"><div class="gs-icon-tile t-violet"><x-icon name="network" class="ic-lg" /></div><span class="btn btn-gs-ghost btn-icon"><x-icon name="dots" /></span></div>
    <h3>Concurso TI</h3><p>Redes de computadores e engenharia de software para o edital de analista.</p>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip">Redes</span><span class="gs-chip">Eng. de Software</span></div>
    <div class="d-flex gap-1 flex-wrap"><span class="gs-chip gs-chip-plain">9 tópicos</span><span class="gs-chip gs-chip-plain">2 simulados</span></div>
    <div><div class="d-flex justify-content-between small mb-1"><span class="text-muted-gs">Domínio do conteúdo</span><b class="text-dark tnum">81%</b></div><div class="gs-bar"><span style="width:81%"></span></div></div>
    <div class="gs-env-foot"><span>Último simulado há 12 dias</span><span class="gs-go"><x-icon name="arrow-r" class="ic-sm" /></span></div>
  </a></div>
  <div class="col-md-6 col-xl-4"><a href="{{ route('ambientes.create') }}" class="gs-card gs-new text-reset">
    <span class="plus"><x-icon name="plus" class="ic-lg" /></span>
    <b class="text-dark">Novo ambiente</b><span class="small" style="max-width:16rem">Reúna tópicos de disciplinas diferentes e gere seu primeiro simulado.</span>
  </a></div>
</div>
@endsection
