@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Olá, Arthur. Vamos praticar?</div><h1 class="gs-page-title">Dashboard</h1></div>
  <a href="{{ route('simulados.create') }}" class="btn btn-gs"><x-icon name="plus" />Novo simulado</a>
</div>

{{-- @component: x-stat-card --}}
<div class="row g-3 mb-3">
  <div class="col-6 col-xl-3"><x-stat-card label="Ambientes" icon="grid" tone="t-indigo">3</x-stat-card></div>
  <div class="col-6 col-xl-3"><x-stat-card label="Simulados feitos" icon="clipboard" tone="t-blue">24</x-stat-card></div>
  <div class="col-6 col-xl-3"><x-stat-card label="Questões respondidas" icon="file" tone="t-violet">360</x-stat-card></div>
  <div class="col-6 col-xl-3"><x-stat-card label="Acertos gerais" icon="target" tone="">70%<span class="gs-delta">+12 pts</span></x-stat-card></div>
</div>

<div class="row g-3 mb-3">
  <div class="col-lg-6">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Desempenho por tópico</h2>
        <select class="form-select form-select-sm w-auto py-1" id="dash-env" aria-label="Ambiente"><option>Faculdade</option><option>Vestibular</option><option>Concurso TI</option></select></div>
      {{-- @component: x-topic-progress --}}
      <x-topic-progress :value="82" display="82%">Triggers</x-topic-progress>
      <x-topic-progress :value="76" display="76%">Funções PostgreSQL</x-topic-progress>
      <x-topic-progress :value="84" display="84%">Pilhas e filas</x-topic-progress>
      <x-topic-progress :value="66" display="66%">Listas encadeadas</x-topic-progress>
      <x-topic-progress :value="38" display="38%" weak>Árvores binárias <span class="gs-chip gs-chip-bad ms-1">fraco</span></x-topic-progress>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Evolução</h2><span class="small text-muted-gs">Média de acertos por mês</span></div>
      <svg viewBox="0 0 520 230" width="100%" role="img" aria-label="Média de acertos: julho 45%, agosto 53%, setembro 50%, outubro 58%, novembro 70%" style="max-width:100%;height:auto">
        <defs><linearGradient id="g-area" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#7a6ee0" stop-opacity=".55"/><stop offset="1" stop-color="#7a6ee0" stop-opacity=".04"/></linearGradient></defs>
        <g font-size="11" fill="#9a99b5" font-family="Inter,sans-serif">
          <line x1="50" x2="505" y1="20" y2="20" stroke="#eeeef6"/><text x="40" y="24" text-anchor="end">100%</text>
          <line x1="50" x2="505" y1="62.5" y2="62.5" stroke="#eeeef6"/><text x="40" y="66" text-anchor="end">75%</text>
          <line x1="50" x2="505" y1="105" y2="105" stroke="#eeeef6"/><text x="40" y="109" text-anchor="end">50%</text>
          <line x1="50" x2="505" y1="147.5" y2="147.5" stroke="#eeeef6"/><text x="40" y="151" text-anchor="end">25%</text>
          <line x1="50" x2="505" y1="190" y2="190" stroke="#e2e2ee"/><text x="40" y="194" text-anchor="end">0%</text>
          <text x="60" y="212" text-anchor="middle">jul</text><text x="165" y="212" text-anchor="middle">ago</text><text x="275" y="212" text-anchor="middle">set</text><text x="385" y="212" text-anchor="middle">out</text><text x="490" y="212" text-anchor="middle">nov</text>
        </g>
        <path d="M60 113.5 L165 99.9 L275 105 L385 91.4 L490 71 L490 190 L60 190Z" fill="url(#g-area)"/>
        <path d="M60 113.5 L165 99.9 L275 105 L385 91.4 L490 71" fill="none" stroke="#6c6ad8" stroke-width="2.5" stroke-linejoin="round"/>
        <g fill="#fff" stroke="#6c6ad8" stroke-width="2"><circle cx="60" cy="113.5" r="4"/><circle cx="165" cy="99.9" r="4"/><circle cx="275" cy="105" r="4"/><circle cx="385" cy="91.4" r="4"/></g>
        <circle cx="490" cy="71" r="6" fill="#6c6ad8" stroke="#fff" stroke-width="2.5"/>
        <rect x="468" y="40" width="44" height="20" rx="10" fill="#1d1b45"/><text x="490" y="54" text-anchor="middle" font-size="11" font-weight="700" fill="#fff" font-family="Inter,sans-serif">70%</text>
      </svg>
    </div>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-12">
    <div class="gs-card">
      <div class="gs-card-head"><h2 class="gs-card-title">Simulados recentes</h2><a href="{{ route('tentativas.index') }}" class="small fw-semibold">Ver histórico</a></div>
      <div class="gs-table-wrap"><table class="gs-table">
        <thead><tr><th>Data</th><th>Simulado</th><th>Ambiente</th><th>Resultado</th><th></th></tr></thead>
        <tbody>
          <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">20/11/2026</td><td class="fw-semibold text-dark">Revisão da Prova 1</td><td>Faculdade</td><td><span class="gs-score">8/10</span> <span class="gs-chip gs-chip-ok ms-1">80%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
          <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">18/11/2026</td><td class="fw-semibold text-dark">Banco de Dados — Triggers</td><td>Faculdade</td><td><span class="gs-score">7/10</span> <span class="gs-chip gs-chip-ok ms-1">70%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
          <tr onclick="window.location='{{ route('tentativas.show') }}'"><td class="tnum">15/11/2026</td><td class="fw-semibold text-dark">Matemática — Funções</td><td>Vestibular</td><td><span class="gs-score">6/10</span> <span class="gs-chip gs-chip-warn ms-1">60%</span></td><td class="text-end"><x-icon name="chev" class="text-muted-gs" /></td></tr>
        </tbody>
      </table></div>
    </div>
  </div>
</div>

<div class="gs-banner">
  <div><h3>Seu ponto fraco: Árvores binárias (38%)</h3><p>Um simulado curto só com esse tópico ajuda a fechar a lacuna antes da prova.</p></div>
  <a href="{{ route('simulados.create') }}" class="btn btn-light text-primary"><x-icon name="refresh" />Praticar agora</a>
</div>
@endsection
