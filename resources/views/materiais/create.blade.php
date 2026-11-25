@extends('layouts.app')

@section('title', 'Upload de material')

@section('content')
<div class="gs-page-head"><div><div class="gs-eyebrow"><a href="{{ route('disciplinas.index') }}">Disciplinas</a> / Enviar material</div><h1 class="gs-page-title">Upload de material</h1></div></div>
<div class="row g-3">
  <div class="col-lg-7">
    <form class="gs-card" onsubmit="event.preventDefault()">
      <div class="mb-3"><label class="form-label" for="up-disc">Disciplina do material</label>
        <select id="up-disc" class="form-select"><option selected>Banco de Dados</option><option>Estrutura de Dados</option><option>Português</option><option>Redes de Computadores</option></select></div>
      <label class="gs-drop d-block" for="up-file" id="up-drop">
        <span class="gs-icon-tile mx-auto mb-2"><x-icon name="upload" class="ic-lg" /></span>
        <b class="d-block text-dark">Arraste seus arquivos ou clique para escolher</b>
        <span class="small">PDF, slides (PPTX) ou anotações (TXT) · até 20 MB por arquivo</span>
        <input type="file" id="up-file" class="d-none" multiple accept=".pdf,.pptx,.txt">
      </label>
      <x-alert type="info" icon="sparkles" class="mt-3">Depois do envio, a IA lê o material e sugere os tópicos. Você revisa a lista antes de usá-la nos ambientes.</x-alert>
    </form>
  </div>
  <div class="col-lg-5">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Envios de Banco de Dados</h2></div>
      {{-- @component: x-material-item --}}
      <div class="gs-file"><span class="gs-ext">PDF</span><div class="meta"><div class="name">Triggers.pdf</div><div class="sub">2,4 MB · enviado hoje</div></div><a href="{{ route('materiais.topicos') }}" class="gs-chip gs-chip-ok">7 tópicos <x-icon name="chev" class="ic-sm" /></a></div>
      <div class="gs-file"><span class="gs-ext">PDF</span><div class="meta"><div class="name">Funções.pdf</div><div class="sub">1,1 MB · enviado hoje</div></div><a href="{{ route('materiais.topicos') }}" class="gs-chip gs-chip-ok">5 tópicos <x-icon name="chev" class="ic-sm" /></a></div>
      <div class="gs-file"><span class="gs-ext">PDF</span><div class="meta"><div class="name">Procedures.pdf</div><div class="sub">Extraindo tópicos com IA…</div><div class="progress mt-1" style="height:5px"><div class="progress-bar" style="width:64%;background:var(--gs-grad)"></div></div></div><span class="gs-spin"></span></div>
      <div class="gs-file"><span class="gs-ext ppt">PPT</span><div class="meta"><div class="name">Slides_Normalizacao.pptx</div><div class="sub">18 slides · na fila</div></div><span class="gs-chip gs-chip-plain">Na fila</span></div>
      <div class="gs-file"><span class="gs-ext">PDF</span><div class="meta"><div class="name">Lista_exercicios_scan.pdf</div><div class="sub">Não foi possível ler o texto. Envie uma versão com texto selecionável.</div></div><span class="gs-chip gs-chip-bad">Erro</span></div>
    </div>
  </div>
</div>
@endsection
