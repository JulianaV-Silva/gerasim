@extends('layouts.app')

@section('title', 'Tópicos extraídos')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow"><a href="{{ route('disciplinas.index') }}">Banco de Dados</a> / Triggers.pdf</div><h1 class="gs-page-title">Tópicos extraídos</h1></div>
</div>
{{-- @partial: partials/alert.blade.php --}}
<x-alert type="ok" icon="check" class="mb-3"><strong>Material processado.</strong> A IA encontrou 7 tópicos em Triggers.pdf (24 páginas). Revise, renomeie ou remova antes de salvar.</x-alert>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="gs-card">
      <div class="gs-card-head"><h2 class="gs-card-title">7 tópicos sugeridos</h2><div class="form-check m-0"><input class="form-check-input" type="checkbox" id="tp-all" checked><label class="form-check-label small" for="tp-all">Selecionar todos</label></div></div>
      <div class="d-flex flex-column gap-2" id="tp-list">
        {{-- @component: x-topic-item --}}
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp1" checked aria-label="Trigger"><div class="flex-grow-1"><div class="fw-semibold text-dark">Trigger</div><div class="small text-muted-gs">Páginas 1–4 · conceito e sintaxe CREATE TRIGGER</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp2" checked aria-label="BEFORE"><div class="flex-grow-1"><div class="fw-semibold text-dark">BEFORE</div><div class="small text-muted-gs">Páginas 5–8 · disparo antes da operação</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp3" checked aria-label="AFTER"><div class="flex-grow-1"><div class="fw-semibold text-dark">AFTER</div><div class="small text-muted-gs">Páginas 9–11 · disparo após a operação</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp4" checked aria-label="NEW"><div class="flex-grow-1"><div class="fw-semibold text-dark">NEW</div><div class="small text-muted-gs">Páginas 12–14 · registro após INSERT/UPDATE</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp5" checked aria-label="OLD"><div class="flex-grow-1"><div class="fw-semibold text-dark">OLD</div><div class="small text-muted-gs">Páginas 12–14 · registro antes de UPDATE/DELETE</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp6" checked aria-label="FOR EACH ROW"><div class="flex-grow-1"><div class="fw-semibold text-dark">FOR EACH ROW × FOR EACH STATEMENT</div><div class="small text-muted-gs">Páginas 15–19</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
        <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff"><input class="form-check-input m-0" type="checkbox" id="tp7" aria-label="Exemplos de auditoria"><div class="flex-grow-1"><div class="fw-semibold text-dark">Exemplos de auditoria</div><div class="small text-muted-gs">Páginas 20–24 · desmarcado: parece exemplo, não tópico</div></div><span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span><button class="btn btn-gs-ghost btn-icon" aria-label="Renomear"><x-icon name="pencil" /></button></div>
      </div>
      <button class="btn btn-gs-outline btn-sm mt-3"><x-icon name="plus" class="ic-sm" />Adicionar tópico manualmente</button>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="gs-card">
      <h2 class="gs-card-title mb-3">Usar nos ambientes</h2>
      <label class="form-label" for="tp-env">Adicionar os tópicos selecionados a</label>
      <select id="tp-env" class="form-select mb-3"><option>Faculdade</option><option>Vestibular</option><option>Concurso TI</option><option>Não adicionar agora</option></select>
      <div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="tp-gen"><label class="form-check-label small" for="tp-gen">Já gerar 5 questões por tópico no banco</label></div>
      <button class="btn btn-gs w-100" onclick="window.location='{{ route('ambientes.show') }}'">Salvar 6 tópicos</button>
    </div>
  </div>
</div>
@endsection
