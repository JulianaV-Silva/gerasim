@extends('layouts.app')

@section('title', 'Banco de questões')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Seu conteúdo</div><h1 class="gs-page-title">Banco de questões</h1></div>
  <button class="btn btn-gs-outline"><x-icon name="plus" />Nova questão</button>
</div>
<div class="gs-card mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-4"><label class="form-label" for="qb-search">Buscar</label><div class="gs-input-icon"><x-icon name="search" /><input id="qb-search" class="form-control" placeholder="Texto do enunciado"></div></div>
    <div class="col-6 col-md-3"><label class="form-label" for="qb-disc">Disciplina</label><select id="qb-disc" class="form-select"><option>Banco de Dados</option><option>Todas</option></select></div>
    <div class="col-6 col-md-3"><label class="form-label" for="qb-topic">Tópico</label><select id="qb-topic" class="form-select"><option>Triggers</option><option>Todos</option></select></div>
    <div class="col-md-2"><label class="form-label" for="qb-orig">Origem</label><select id="qb-orig" class="form-select"><option>Todas</option><option>Gerada pela IA</option><option>Criada por mim</option></select></div>
  </div>
</div>
<div class="gs-card">
  <div class="gs-card-head"><h2 class="gs-card-title">12 questões em Triggers</h2><span class="small text-muted-gs">Reutilizadas automaticamente ao gerar simulados</span></div>
  {{-- @component: x-question-bank-item --}}
  <div class="gs-qbank-item">
    <div class="d-flex gap-2 flex-wrap"><span class="gs-chip">Triggers</span><span class="gs-chip gs-chip-ai"><x-icon name="sparkles" class="ic-sm" />Gerada pela IA</span><span class="gs-chip gs-chip-plain">Usada em 3 simulados · 83% de acerto</span></div>
    <p class="q">Qual comando é utilizado para criar uma trigger no PostgreSQL?</p>
    <ol><li class="ok">CREATE TRIGGER ✓</li><li>ADD TRIGGER</li><li>NEW TRIGGER</li><li>MAKE TRIGGER</li></ol>
  </div>
  <div class="gs-qbank-item">
    <div class="d-flex gap-2 flex-wrap"><span class="gs-chip">Triggers</span><span class="gs-chip gs-chip-ai"><x-icon name="sparkles" class="ic-sm" />Gerada pela IA</span><span class="gs-chip gs-chip-plain">Usada em 2 simulados · 50% de acerto</span></div>
    <p class="q">Em uma trigger BEFORE UPDATE, qual variável contém os valores da linha depois da alteração?</p>
    <ol><li class="ok">NEW ✓</li><li>OLD</li><li>CURRENT</li><li>ROW</li></ol>
  </div>
  <div class="gs-qbank-item">
    <div class="d-flex gap-2 flex-wrap"><span class="gs-chip">Triggers</span><span class="gs-chip gs-chip-plain">Criada por mim</span><span class="gs-chip gs-chip-plain">Nunca usada</span></div>
    <p class="q">Qual o tipo de retorno de uma função chamada por uma trigger?</p>
    <ol><li class="ok">RETURNS TRIGGER ✓</li><li>RETURNS VOID</li><li>RETURNS RECORD</li><li>RETURNS TABLE</li></ol>
  </div>
  <nav class="d-flex justify-content-center gap-1 mt-3" aria-label="Paginação"><button class="btn btn-gs-dark btn-icon btn-sm">1</button><button class="btn btn-gs-ghost btn-icon btn-sm">2</button><button class="btn btn-gs-ghost btn-icon btn-sm">3</button><button class="btn btn-gs-ghost btn-icon btn-sm">4</button></nav>
</div>
@endsection
