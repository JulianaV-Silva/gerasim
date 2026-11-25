@extends('layouts.app')

@section('title', 'Criar simulado')

@section('content')
<div class="gs-page-head"><div><div class="gs-eyebrow"><a href="{{ route('ambientes.show') }}">Faculdade</a> / Novo simulado</div><h1 class="gs-page-title">Criar simulado</h1></div></div>
<form class="row g-3" onsubmit="event.preventDefault();window.location='{{ route('simulados.resolver') }}'">
  <div class="col-lg-8">
    <div class="gs-card mb-3">
      <div class="row g-3">
        <div class="col-md-8"><label class="form-label" for="sim-name">Nome do simulado</label><input id="sim-name" class="form-control" value="Revisão da Prova"></div>
        <div class="col-md-4"><label class="form-label" for="sim-total">Total de questões</label><input id="sim-total" type="number" min="1" max="50" class="form-control tnum" value="10"></div>
      </div>
    </div>
    <div class="gs-card">
      <div class="gs-card-head mb-2"><div><h2 class="gs-card-title">Tópicos</h2><div class="small text-muted-gs">Tópicos do ambiente Faculdade. O número indica quantas questões já existem no banco.</div></div></div>
      <div class="gs-topic-pick my-3" id="sim-topics">
        <input type="checkbox" id="st1" value="Triggers" data-bank="4" checked><label for="st1"><x-icon name="check" class="ic-sm tick" />Triggers <span class="n">· 4 no banco</span></label>
        <input type="checkbox" id="st2" value="Estrutura de Dados" data-bank="3" checked><label for="st2"><x-icon name="check" class="ic-sm tick" />Estrutura de Dados <span class="n">· 3</span></label>
        <input type="checkbox" id="st3" value="Funções" data-bank="0" checked><label for="st3"><x-icon name="check" class="ic-sm tick" />Funções <span class="n">· 0</span></label>
        <input type="checkbox" id="st4" value="Árvores binárias" data-bank="4"><label for="st4"><x-icon name="check" class="ic-sm tick" />Árvores binárias <span class="n">· 4</span></label>
        <input type="checkbox" id="st5" value="Procedures" data-bank="0"><label for="st5"><x-icon name="check" class="ic-sm tick" />Procedures <span class="n">· 0</span></label>
      </div>
      <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" role="switch" id="sim-custom" checked><label class="form-check-label fw-semibold text-dark" for="sim-custom">Definir quantas questões por tópico</label></div>
      <div id="sim-dist" class="d-flex flex-column gap-2 mt-3"></div>
      <div id="sim-dist-alert" class="mt-3"></div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="gs-card position-sticky" style="top:1rem">
      <h2 class="gs-card-title mb-3">Como o simulado será montado</h2>
      <div class="d-flex align-items-center gap-3 mb-2"><div class="gs-icon-tile t-soft"><x-icon name="database" /></div><div class="flex-grow-1"><div class="small text-muted-gs">Reaproveitadas do banco</div><div class="gs-score fs-5" id="sum-reuse">7</div></div></div>
      <div class="d-flex align-items-center gap-3 mb-3"><div class="gs-icon-tile"><x-icon name="sparkles" /></div><div class="flex-grow-1"><div class="small text-muted-gs">Novas, geradas pela IA</div><div class="gs-score fs-5" id="sum-new">3</div></div></div>
      <div class="gs-bar mb-1" style="height:10px;background:#e9d9f8"><span id="sum-bar" style="width:70%;background:#6c6ad8"></span></div>
      <div class="small text-muted-gs mb-3" id="sum-note">A IA só é chamada para as questões que faltam no banco.</div>
      <button class="btn btn-gs w-100" type="submit" id="sim-submit">Gerar simulado</button>
      <a href="{{ route('ambientes.show') }}" class="btn btn-gs-ghost w-100 mt-2">Cancelar</a>
    </div>
  </div>
</form>
@endsection
