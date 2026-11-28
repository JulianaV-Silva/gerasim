@extends('layouts.app')

@section('title', 'Tópicos extraídos')

@section('content')
<div class="gs-page-head">
  <div>
    <div class="gs-eyebrow"><a href="{{ route('materiais.create') }}">Materiais</a> / {{{ $tituloMateriais }}}</div>
    <h1 class="gs-page-title">Tópicos extraídos</h1>
  </div>
</div>

{{-- @partial: partials/alert.blade.php --}}
<x-alert type="ok" icon="check" class="mb-3">
  <strong>Material processado.</strong> A IA encontrou {{ count($topicosSugeridos) }} {{ count($topicosSugeridos) === 1 ? 'tópico' : 'tópicos' }} em {{{ $tituloMateriais }}}. Revise, renomeie ou remova antes de salvar.
</x-alert>

<form class="row g-3" action="{{ route('materiais.salvarTopicos', ['id' => $material->id_material]) }}" method="POST">
  @csrf
  <div class="col-lg-8">
    <div class="gs-card">
      <div class="gs-card-head">
        <h2 class="gs-card-title">{{ count($topicosSugeridos) }} tópicos sugeridos</h2>
        <div class="form-check m-0">
          <input class="form-check-input" type="checkbox" id="tp-all" checked>
          <label class="form-check-label small" for="tp-all">Selecionar todos</label>
        </div>
      </div>

      <div class="d-flex flex-column gap-2" id="tp-list">
        @forelse($topicosSugeridos as $idx => $topico)
          <div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff">
            <input class="form-check-input m-0 tp-check" type="checkbox" name="topicos[{{ $idx }}][selecionado]" value="1" checked>
            <div class="flex-grow-1">
              <input type="text" name="topicos[{{ $idx }}][nm_topico]" class="form-control form-control-sm fw-semibold text-dark mb-1" value="{{ $topico['nm_topico'] }}" required>
              <input type="text" name="topicos[{{ $idx }}][ds_descricao]" class="form-control form-control-sm text-muted-gs" value="{{ $topico['ds_descricao'] ?? '' }}">
            </div>
            <span class="gs-chip gs-chip-ai d-none d-sm-inline-flex"><x-icon name="sparkles" class="ic-sm" />IA</span>
          </div>
        @empty
          <p class="small text-muted-gs mb-0">Nenhum tópico em sessão para este material. Tente enviar novamente.</p>
        @endforelse
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="gs-card">
      <h2 class="gs-card-title mb-3">Usar nos ambientes</h2>

      <label class="form-label" for="tp-env">Adicionar os tópicos selecionados a</label>
      <select id="tp-env" name="id_ambiente" class="form-select mb-3">
        @foreach($ambientes as $amb)
          <option value="{{ $amb->id_ambiente }}" @selected($amb->id_ambiente == $material->id_ambiente)>
            {{ $amb->nm_ambiente }}
          </option>
        @endforeach
        <option value="">Não adicionar agora</option>
      </select>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="tp-gen" name="gerar_questoes" value="1">
        <label class="form-check-label small" for="tp-gen">Já gerar 5 questões por tópico no banco</label>
      </div>

      <button type="submit" class="btn btn-gs w-100" id="tp-submit">
        Salvar tópicos selecionados
      </button>
    </div>
  </div>
</form>

{{-- Overlay de carregamento enquanto a IA processa --}}
<div id="loading-overlay" class="d-none position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
     style="background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999;">
  <div class="bg-white rounded-4 p-4 p-md-5 text-center shadow-lg" style="max-width: 420px; width: 90%;">
    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
      <span class="visually-hidden">Carregando...</span>
    </div>
    <h5 class="fw-bold text-dark mb-2" id="loading-title">Salvando tópicos...</h5>
    <p class="small text-muted-gs mb-0" id="loading-desc">
      Aguarde um instante enquanto preparamos tudo para você.
    </p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const formTopicos = document.querySelector('form[action*="topicos"]');
    const overlay = document.getElementById('loading-overlay');
    const loadingTitle = document.getElementById('loading-title');
    const loadingDesc = document.getElementById('loading-desc');
    const btnSubmit = document.getElementById('tp-submit');
    const checkTodos = document.getElementById('tp-all');
    const checkboxesTopicos = document.querySelectorAll('.tp-check');

    function atualizarEstadoBotao() {
      if (!btnSubmit) return;
      const total = checkboxesTopicos.length;
      const selecionados = document.querySelectorAll('.tp-check:checked').length;

      btnSubmit.disabled = selecionados === 0;
      btnSubmit.textContent = selecionados === 1
        ? 'Salvar 1 tópico selecionado'
        : `Salvar ${selecionados} tópicos selecionados`;

      if (checkTodos && total > 0) {
        checkTodos.checked = selecionados === total;
        checkTodos.indeterminate = selecionados > 0 && selecionados < total;
      }
    }

    if (checkTodos) {
      checkTodos.addEventListener('change', () => {
        checkboxesTopicos.forEach(c => c.checked = checkTodos.checked);
        atualizarEstadoBotao();
      });
    }

    checkboxesTopicos.forEach(cb => cb.addEventListener('change', atualizarEstadoBotao));
    atualizarEstadoBotao();

    if (formTopicos && overlay) {
      formTopicos.addEventListener('submit', () => {
        const gerarQuestoes = document.getElementById('tp-gen')?.checked;

        if (gerarQuestoes) {
          loadingTitle.textContent = 'A IA está criando suas questões...';
          loadingDesc.textContent = 'Estamos gerando as questões personalizadas com base no seu material. Isso pode levar alguns segundos.';
        } else {
          loadingTitle.textContent = 'Salvando tópicos selecionados...';
          loadingDesc.textContent = 'Registrando os tópicos no seu ambiente de estudo.';
        }

        if (btnSubmit) {
          btnSubmit.disabled = true;
          btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processando...';
        }

        overlay.classList.remove('d-none');
        overlay.classList.add('d-flex');
      });
    }
  });
</script>
@endsection