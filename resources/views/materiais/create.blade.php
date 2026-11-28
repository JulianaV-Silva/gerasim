@extends('layouts.app')

@section('title', 'Upload de material')

@section('content')
<div class="gs-page-head">
  <div>
    <div class="gs-eyebrow"><a href="{{ route('disciplinas.index') }}">Disciplinas</a> / Enviar material</div>
    <h1 class="gs-page-title">Upload de material</h1>
  </div>
</div>

@if(session('erro'))
  <x-alert type="err" icon="alert" class="mb-3">{{ session('erro') }}</x-alert>
@endif

@if(session('sucesso'))
  <x-alert type="ok" icon="check" class="mb-3">{{ session('sucesso') }}</x-alert>
@endif

<div class="row g-3">
  <div class="col-lg-7">
    <form class="gs-card" action="{{ route('materiais.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label" for="up-disc">Disciplina do material</label>
        <select id="up-disc" name="id_ambiente" class="form-select" required>
          @foreach($ambientes as $amb)
            <option value="{{ $amb->id_ambiente }}" @selected($amb->id_ambiente == ($idAmbienteSelecionado ?? 0))>
              {{ $amb->nm_ambiente }}
            </option>
          @endforeach
        </select>
      </div>
      <label class="gs-drop d-block" for="up-file" id="up-drop" style="cursor: pointer;">
        <span class="gs-icon-tile mx-auto mb-2"><x-icon name="upload" class="ic-lg" /></span>
        <b class="d-block text-dark" id="up-title">Arraste seus arquivos ou clique para escolher</b>
        <span class="small" id="up-subtitle">PDF, slides (PPTX) ou anotações (TXT) · até 20 MB por arquivo</span>
        
        <input type="file" id="up-file" name="arquivos[]" class="d-none" multiple accept=".pdf,.pptx,.txt,.png,.jpg,.jpeg" required>
        
        {{-- Lista visual dos arquivos selecionados --}}
        <div id="up-file-list" class="mt-3 d-flex flex-column gap-1 text-start"></div>
      </label>
      @error('arquivos')
        <div class="text-danger small mt-2">{{ $message }}</div>
      @enderror
      @error('arquivos.*')
        <div class="text-danger small mt-2">{{ $message }}</div>
      @enderror
      <x-alert type="info" icon="sparkles" class="mt-3">
        Depois do envio, a IA lê o material e sugere os tópicos. Você revisa a lista antes de usá-la nos ambientes.
      </x-alert>
      <button type="submit" class="btn btn-gs w-100 mt-3">
        <x-icon name="sparkles" /> Enviar e extrair tópicos com IA
      </button>
    </form>
  </div>
  <div class="col-lg-5">
    <div class="gs-card h-100">
      <div class="gs-card-head"><h2 class="gs-card-title">Envios recentes</h2></div>
      {{-- @component: x-material-item --}}
      @forelse($materiais as $mat)
        <div class="gs-file">
          <span class="gs-ext">ARQ</span>
          <div class="meta">
            <div class="name">{{ $mat->nm_material }}</div>
            <div class="sub">{{ $mat->fl_processamento ? 'Processado' : 'Aguardando confirmação' }}</div>
          </div>
          @if($mat->fl_processamento)
            <span class="gs-chip gs-chip-ok">Salvo</span>
          @else
            <a href="{{ route('materiais.topicos', ['id' => $mat->id_material]) }}" class="gs-chip gs-chip-plain">
              Revisar <x-icon name="chev" class="ic-sm" />
            </a>
          @endif
        </div>
      @empty
        <p class="small text-muted-gs mb-0">Nenhum material enviado ainda.</p>
      @endforelse
    </div>
  </div>
</div>
<script>
  const inputArquivo = document.getElementById('up-file');
  const dropArea = document.getElementById('up-drop');
  const listaArquivos = document.getElementById('up-file-list');
  const tituloUpload = document.getElementById('up-title');

  function atualizarListaArquivos(files) {
    listaArquivos.innerHTML = '';

    if (!files || files.length === 0) {
      tituloUpload.textContent = 'Arraste seus arquivos ou clique para escolher';
      return;
    }

    tituloUpload.textContent = files.length === 1
      ? '1 arquivo selecionado:'
      : `${files.length} arquivos selecionados:`;

    Array.from(files).forEach((file) => {
      const tamanhoMB = (file.size / (1024 * 1024)).toFixed(2);
      const item = document.createElement('div');
      item.className = 'px-3 py-2 rounded bg-light border d-flex justify-content-between align-items-center small';
      item.innerHTML = `<span class="text-dark fw-medium text-truncate" style="max-width: 75%;">${file.name}</span><span class="text-muted-gs">${tamanhoMB} MB</span>`;
      listaArquivos.appendChild(item);
    });
  }

  // Quando escolhe clicando na caixa
  inputArquivo.addEventListener('change', (e) => {
    atualizarListaArquivos(e.target.files);
  });

  // Suporte visual e funcional para arrastar e soltar (Drag & Drop)
  ['dragenter', 'dragover'].forEach((evento) => {
    dropArea.addEventListener(evento, (e) => {
      e.preventDefault();
      dropArea.style.borderColor = '#635bff';
      dropArea.style.backgroundColor = '#f8f7ff';
    });
  });

  ['dragleave', 'drop'].forEach((evento) => {
    dropArea.addEventListener(evento, (e) => {
      e.preventDefault();
      dropArea.style.borderColor = '';
      dropArea.style.backgroundColor = '';
    });
  });

  dropArea.addEventListener('drop', (e) => {
    if (e.dataTransfer.files.length > 0) {
      inputArquivo.files = e.dataTransfer.files;
      atualizarListaArquivos(e.dataTransfer.files);
    }
  });
</script>

{{-- Overlay de carregamento enquanto a IA extrai os tópicos dos materiais --}}
<div id="upload-loading-overlay" class="d-none position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
     style="background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999;">
  <div class="bg-white rounded-4 p-4 p-md-5 text-center shadow-lg" style="max-width: 420px; width: 90%;">
    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
      <span class="visually-hidden">Carregando...</span>
    </div>
    <h5 class="fw-bold text-dark mb-2" id="upload-loading-title">Lendo materiais com IA...</h5>
    <p class="small text-muted-gs mb-0" id="upload-loading-desc">
      Estamos analisando seus arquivos e extraindo os principais tópicos de estudo. Aguarde um instante.
    </p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const formUpload = document.querySelector('form[action*="materiais"]');
    const overlayUpload = document.getElementById('upload-loading-overlay');
    const titleUpload = document.getElementById('upload-loading-title');
    const descUpload = document.getElementById('upload-loading-desc');

    if (formUpload && overlayUpload) {
      formUpload.addEventListener('submit', () => {
        const qtdArquivos = document.getElementById('up-file')?.files?.length || 1;

        if (qtdArquivos > 1) {
          titleUpload.textContent = `Analisando ${qtdArquivos} materiais com IA...`;
          descUpload.textContent = 'A IA está lendo cada arquivo enviado para sugerir os tópicos. Isso pode levar alguns segundos.';
        }

        const btnSubmit = formUpload.querySelector('button[type="submit"]');
        if (btnSubmit) {
          btnSubmit.disabled = true;
          btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Extraindo tópicos...';
        }

        overlayUpload.classList.remove('d-none');
        overlayUpload.classList.add('d-flex');
      });
    }
  });
</script>
@endsection