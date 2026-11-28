@extends('layouts.app')

@section('title', 'Disciplinas e materiais')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow">Seu conteúdo</div><h1 class="gs-page-title">Disciplinas e materiais</h1></div>
  <div class="d-flex gap-2 flex-wrap"><a href="{{ route('materiais.create') }}" class="btn btn-gs-outline"><x-icon name="upload" />Enviar material</a><a href="{{ route('disciplinas.create') }}" class="btn btn-gs"><x-icon name="plus" />Adicionar disciplina</a></div>
</div>
<div class="row g-3">
  {{-- @component: x-subject-card --}}
  <div class="col-md-6 col-xl-4"><div class="gs-card h-100 d-flex flex-column gap-3">
    <div class="d-flex gap-3 align-items-center"><div class="gs-icon-tile t-indigo"><x-icon name="database" class="ic-lg" /></div><div><h3 class="h6 m-0">Banco de Dados</h3><div class="small text-muted-gs">3 materiais · 14 tópicos</div></div></div>
    <div>
      <a href="{{ route('materiais.topicos') }}" class="gs-file text-reset py-2"><span class="gs-ext" style="width:32px;height:32px;font-size:.6rem">PDF</span><span class="meta"><span class="name d-block small">Triggers.pdf</span></span><span class="gs-chip gs-chip-ok">7 tópicos</span></a>
      <a href="{{ route('materiais.topicos') }}" class="gs-file text-reset py-2"><span class="gs-ext" style="width:32px;height:32px;font-size:.6rem">PDF</span><span class="meta"><span class="name d-block small">Funções.pdf</span></span><span class="gs-chip gs-chip-ok">5 tópicos</span></a>
      <a href="{{ route('materiais.create') }}" class="gs-file text-reset py-2"><span class="gs-ext" style="width:32px;height:32px;font-size:.6rem">PDF</span><span class="meta"><span class="name d-block small">Procedures.pdf</span></span><span class="gs-chip"><span class="gs-spin"></span> Processando</span></a>
    </div>
    <a href="{{ route('materiais.create') }}" class="btn btn-gs-outline btn-sm mt-auto align-self-start"><x-icon name="upload" class="ic-sm" />Enviar material</a>
  </div></div>
  <div class="col-md-6 col-xl-4"><div class="gs-card h-100 d-flex flex-column gap-3">
    <div class="d-flex gap-3 align-items-center"><div class="gs-icon-tile t-blue"><x-icon name="git" class="ic-lg" /></div><div><h3 class="h6 m-0">Estrutura de Dados</h3><div class="small text-muted-gs">2 materiais · 9 tópicos</div></div></div>
    <div>
      <a href="{{ route('materiais.topicos') }}" class="gs-file text-reset py-2"><span class="gs-ext ppt" style="width:32px;height:32px;font-size:.6rem">PPT</span><span class="meta"><span class="name d-block small">Aula05_Pilhas_Filas.pptx</span></span><span class="gs-chip gs-chip-ok">4 tópicos</span></a>
      <a href="{{ route('materiais.topicos') }}" class="gs-file text-reset py-2"><span class="gs-ext" style="width:32px;height:32px;font-size:.6rem">PDF</span><span class="meta"><span class="name d-block small">Arvores_Binarias.pdf</span></span><span class="gs-chip gs-chip-ok">5 tópicos</span></a>
    </div>
    <a href="{{ route('materiais.create') }}" class="btn btn-gs-outline btn-sm mt-auto align-self-start"><x-icon name="upload" class="ic-sm" />Enviar material</a>
  </div></div>
  <div class="col-md-6 col-xl-4"><div class="gs-card h-100 d-flex flex-column gap-3">
    <div class="d-flex gap-3 align-items-center"><div class="gs-icon-tile t-violet"><x-icon name="book" class="ic-lg" /></div><div><h3 class="h6 m-0">Português</h3><div class="small text-muted-gs">1 material · 6 tópicos</div></div></div>
    <div>
      <a href="{{ route('materiais.topicos') }}" class="gs-file text-reset py-2"><span class="gs-ext txt" style="width:32px;height:32px;font-size:.6rem">TXT</span><span class="meta"><span class="name d-block small">Anotacoes_interpretacao.txt</span></span><span class="gs-chip gs-chip-ok">6 tópicos</span></a>
    </div>
    <a href="{{ route('materiais.create') }}" class="btn btn-gs-outline btn-sm mt-auto align-self-start"><x-icon name="upload" class="ic-sm" />Enviar material</a>
  </div></div>
  <div class="col-md-6 col-xl-4"><div class="gs-card h-100 d-flex flex-column gap-3">
    <div class="d-flex gap-3 align-items-center"><div class="gs-icon-tile"><x-icon name="network" class="ic-lg" /></div><div><h3 class="h6 m-0">Redes de Computadores <span class="gs-chip gs-chip-plain ms-1">Outros</span></h3><div class="small text-muted-gs">0 materiais</div></div></div>
    <div class="small text-muted-gs">Nenhum material ainda. Envie um PDF para a IA identificar os tópicos.</div>
    <a href="{{ route('materiais.create') }}" class="btn btn-gs btn-sm mt-auto align-self-start"><x-icon name="upload" class="ic-sm" />Enviar primeiro material</a>
  </div></div>
</div>
@endsection
