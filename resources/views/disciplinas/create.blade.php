@extends('layouts.app')

@section('title', 'Adicionar disciplina')

@section('content')
<div class="gs-page-head"><div><div class="gs-eyebrow"><a href="{{ route('disciplinas.index') }}">Disciplinas</a> / Nova</div><h1 class="gs-page-title">Adicionar disciplina</h1></div></div>
<div class="row"><div class="col-lg-7 col-xl-6">
  <form class="gs-card" onsubmit="event.preventDefault();window.location='{{ route('materiais.create') }}'">
    <div class="mb-3">
      <label class="form-label" for="disc-select">Disciplina</label>
      <select id="disc-select" class="form-select">
        <option>Banco de Dados</option><option>Estrutura de Dados</option><option>Português</option><option>Matemática</option><option value="outros" selected>Outros</option>
      </select>
    </div>
    <div class="mb-3" id="disc-other-wrap">
      <label class="form-label" for="disc-other">Nome da disciplina</label>
      <input id="disc-other" class="form-control" value="Redes de Computadores">
      <div class="form-text">Aparece quando você escolhe "Outros".</div>
    </div>
    <div class="mb-4"><label class="form-label" for="disc-desc">Descrição <span class="text-muted-gs fw-normal">(opcional)</span></label><textarea id="disc-desc" class="form-control" rows="2">Modelo OSI, TCP/IP e roteamento.</textarea></div>
    <div class="d-flex gap-2 flex-wrap"><button class="btn btn-gs" type="submit">Salvar e enviar material</button><a href="{{ route('disciplinas.index') }}" class="btn btn-gs-ghost">Cancelar</a></div>
  </form>
</div></div>
@endsection
