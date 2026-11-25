@extends('layouts.app')

@section('title', 'Criar ambiente')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow"><a href="{{ route('ambientes.index') }}">Meus ambientes</a> / Novo</div><h1 class="gs-page-title">Criar ambiente de estudo</h1></div>
</div>
<form class="row g-3" onsubmit="event.preventDefault();window.location='{{ route('ambientes.show') }}'">
  <div class="col-lg-8">
    <div class="gs-card mb-3">
      <div class="mb-3"><label class="form-label" for="env-name">Nome do ambiente</label><input id="env-name" class="form-control" value="Faculdade"><div class="form-text">Um ambiente pode reunir tópicos de várias disciplinas, por exemplo "Faculdade" ou "Vestibular".</div></div>
      <div class="mb-3"><label class="form-label" for="env-desc">Descrição <span class="text-muted-gs fw-normal">(opcional)</span></label><textarea id="env-desc" class="form-control" rows="2">Revisão para a prova do 4º período.</textarea></div>
      <label class="form-label d-block">Ícone</label>
      <div class="d-flex gap-2 flex-wrap" role="radiogroup" aria-label="Ícone do ambiente">
        <button type="button" class="gs-icon-tile t-indigo border-0" style="outline:3px solid #a9a3ef;outline-offset:2px" aria-pressed="true"><x-icon name="grad" class="ic-lg" /></button>
        <button type="button" class="gs-icon-tile t-blue border-0"><x-icon name="pencil" class="ic-lg" /></button>
        <button type="button" class="gs-icon-tile t-violet border-0"><x-icon name="network" class="ic-lg" /></button>
        <button type="button" class="gs-icon-tile border-0"><x-icon name="database" class="ic-lg" /></button>
        <button type="button" class="gs-icon-tile t-soft border-0"><x-icon name="book" class="ic-lg" /></button>
      </div>
    </div>
    <div class="gs-card">
      <div class="gs-card-head mb-2"><div><h2 class="gs-card-title">Tópicos do ambiente</h2><div class="small text-muted-gs">Escolha entre os tópicos já extraídos dos seus materiais.</div></div><a href="{{ route('materiais.create') }}" class="btn btn-gs-outline btn-sm"><x-icon name="upload" class="ic-sm" />Enviar material</a></div>
      <p class="gs-section-label mt-3">Banco de Dados</p>
      <div class="gs-topic-pick mb-3">
        <input type="checkbox" id="et1" checked><label for="et1"><x-icon name="check" class="ic-sm tick" />Triggers <span class="n">· 12 questões</span></label>
        <input type="checkbox" id="et2" checked><label for="et2"><x-icon name="check" class="ic-sm tick" />Funções PostgreSQL <span class="n">· 6</span></label>
        <input type="checkbox" id="et3"><label for="et3"><x-icon name="check" class="ic-sm tick" />Procedures <span class="n">· 0</span></label>
        <input type="checkbox" id="et4"><label for="et4"><x-icon name="check" class="ic-sm tick" />Normalização <span class="n">· 9</span></label>
      </div>
      <p class="gs-section-label">Estrutura de Dados</p>
      <div class="gs-topic-pick mb-3">
        <input type="checkbox" id="et5" checked><label for="et5"><x-icon name="check" class="ic-sm tick" />Pilhas e filas <span class="n">· 8</span></label>
        <input type="checkbox" id="et6" checked><label for="et6"><x-icon name="check" class="ic-sm tick" />Listas encadeadas <span class="n">· 5</span></label>
        <input type="checkbox" id="et7" checked><label for="et7"><x-icon name="check" class="ic-sm tick" />Árvores binárias <span class="n">· 4</span></label>
      </div>
      <p class="gs-section-label">Português</p>
      <div class="gs-topic-pick">
        <input type="checkbox" id="et8"><label for="et8"><x-icon name="check" class="ic-sm tick" />Interpretação de texto <span class="n">· 14</span></label>
        <input type="checkbox" id="et9"><label for="et9"><x-icon name="check" class="ic-sm tick" />Concordância <span class="n">· 7</span></label>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="gs-card position-sticky" style="top:1rem">
      <h2 class="gs-card-title mb-3">Resumo</h2>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Tópicos selecionados</span><b class="text-dark">5</b></div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Disciplinas</span><b class="text-dark">2</b></div>
      <div class="d-flex justify-content-between py-2 mb-3"><span class="text-muted-gs">Questões no banco</span><b class="text-dark">35</b></div>
      <button class="btn btn-gs w-100" type="submit">Criar ambiente</button>
      <a href="{{ route('ambientes.index') }}" class="btn btn-gs-ghost w-100 mt-2">Cancelar</a>
    </div>
  </div>
</form>
@endsection
