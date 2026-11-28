@extends('layouts.app')

@section('title', 'Histórico')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Prática</div><h1 class="gs-page-title">Histórico de simulados</h1></div>
  <div class="d-flex gap-2 flex-wrap"><select class="form-select w-auto" id="hist-env" aria-label="Ambiente"><option>Todos os ambientes</option><option>Faculdade</option><option>Vestibular</option><option>Concurso TI</option></select><select class="form-select w-auto" id="hist-period" aria-label="Período"><option>Últimos 30 dias</option><option>Últimos 90 dias</option><option>Tudo</option></select></div>
</div>
<div class="gs-card">
  <div class="gs-table-wrap"><table class="gs-table">
    <thead><tr><th>Data</th><th>Simulado</th><th>Ambiente</th><th>Questões</th><th>Resultado</th><th></th></tr></thead>
    <tbody>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">20/11/2026</td><td class="fw-semibold text-dark">Revisão da Prova 1</td><td>Faculdade</td><td class="tnum">10</td><td><span class="gs-score">8/10</span> <span class="gs-chip gs-chip-ok ms-1">80%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">18/11/2026</td><td class="fw-semibold text-dark">Banco de Dados — Triggers</td><td>Faculdade</td><td class="tnum">10</td><td><span class="gs-score">7/10</span> <span class="gs-chip gs-chip-ok ms-1">70%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">15/11/2026</td><td class="fw-semibold text-dark">Matemática — Funções</td><td>Vestibular</td><td class="tnum">10</td><td><span class="gs-score">6/10</span> <span class="gs-chip gs-chip-warn ms-1">60%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">12/11/2026</td><td class="fw-semibold text-dark">Redes — Camada de transporte</td><td>Concurso TI</td><td class="tnum">12</td><td><span class="gs-score">11/12</span> <span class="gs-chip gs-chip-ok ms-1">92%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">08/11/2026</td><td class="fw-semibold text-dark">Revisão de Funções</td><td>Faculdade</td><td class="tnum">8</td><td><span class="gs-score">5/8</span> <span class="gs-chip gs-chip-warn ms-1">63%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
      <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">03/11/2026</td><td class="fw-semibold text-dark">Redação — Coesão</td><td>Vestibular</td><td class="tnum">10</td><td><span class="gs-score">4/10</span> <span class="gs-chip gs-chip-bad ms-1">40%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
    </tbody>
  </table></div>
</div>
@endsection
