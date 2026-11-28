@extends('layouts.app')

@section('title', 'Criar ambiente')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow"><a href="{{ route('ambientes.index') }}">Meus ambientes</a> / Novo</div><h1 class="gs-page-title">Criar ambiente de estudo</h1></div>
</div>

<form class="row g-3" action="{{ route('ambientes.store') }}" method="POST">
  @csrf
  <div class="col-lg-8">
    <div class="gs-card mb-3">
      <div class="mb-3">
        <label class="form-label" for="env-name">Nome do ambiente</label>
        <input id="env-name" name="nm_ambiente" class="form-control" placeholder="Ex: Faculdade, Concurso TI..." value="{{ old('nm_ambiente') }}" required maxlength="60">
        @error('nm_ambiente')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        <div class="form-text">Um ambiente pode reunir tópicos de várias disciplinas, por exemplo "Faculdade" ou "Vestibular".</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="env-desc">Descrição <span class="text-muted-gs fw-normal">(opcional)</span></label>
        <textarea id="env-desc" name="ds_descricao" class="form-control" rows="2" placeholder="Ex: Revisão para a prova do 4º período.">{{ old('ds_descricao') }}</textarea>
      </div>

      <label class="form-label d-block">Ícone</label>
      <input type="hidden" name="ds_icone" id="env-icon-input" value="grad">

      <div class="d-flex gap-2 flex-wrap" id="env-icon-group" role="radiogroup" aria-label="Ícone do ambiente">
        <button type="button" data-icon="grad" class="gs-icon-tile t-indigo border-0" style="outline:3px solid #a9a3ef;outline-offset:2px" aria-pressed="true">
          <x-icon name="grad" class="ic-lg" />
        </button>
        <button type="button" data-icon="pencil" class="gs-icon-tile t-blue border-0" aria-pressed="false">
          <x-icon name="pencil" class="ic-lg" />
        </button>
        <button type="button" data-icon="network" class="gs-icon-tile t-violet border-0" aria-pressed="false">
          <x-icon name="network" class="ic-lg" />
        </button>
        <button type="button" data-icon="database" class="gs-icon-tile border-0" aria-pressed="false">
          <x-icon name="database" class="ic-lg" />
        </button>
        <button type="button" data-icon="book" class="gs-icon-tile t-soft border-0" aria-pressed="false">
          <x-icon name="book" class="ic-lg" />
        </button>
      </div>

      <script>
        document.querySelectorAll('#env-icon-group button').forEach((btn) => {
          btn.addEventListener('click', () => {
            document.querySelectorAll('#env-icon-group button').forEach((b) => {
              b.style.outline = 'none';
              b.setAttribute('aria-pressed', 'false');
            });
            btn.style.outline = '3px solid #a9a3ef';
            btn.style.outlineOffset = '2px';
            btn.setAttribute('aria-pressed', 'true');
            document.getElementById('env-icon-input').value = btn.dataset.icon;
          });
        });
      </script>
    </div>

    <div class="gs-card">
      <div class="gs-card-head mb-2">
        <div>
          <h2 class="gs-card-title">Tópicos disponíveis no banco</h2>
          <div class="small text-muted-gs">Tópicos extraídos dos seus materiais enviados.</div>
        </div>
        <button type="submit" name="acao" value="enviar_material" class="btn btn-gs-outline btn-sm">
          <x-icon name="upload" class="ic-sm" />Enviar material
        </button>
      </div>

      @if($topicos->isEmpty())
        <p class="small text-muted-gs mt-3 mb-0">Nenhum tópico extraído ainda. Crie o ambiente primeiro e depois envie um material.</p>
      @else
        <div class="gs-topic-pick mt-3">
          @foreach($topicos as $topico)
            <input type="checkbox" id="et{{ $topico->id_topico }}" name="ids_topicos[]" value="{{ $topico->id_topico }}">
            <label for="et{{ $topico->id_topico }}">
              <x-icon name="check" class="ic-sm tick" />{{ $topico->nm_topico }}
              <span class="n">· {{ $topico->qtd_questoes }} questões</span>
            </label>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <div class="col-lg-4">
    <div class="gs-card position-sticky" style="top:1rem">
      <h2 class="gs-card-title mb-3">Resumo</h2>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Tópicos no acervo</span><b class="text-dark">{{ $topicos->count() }}</b></div>
      <div class="d-flex justify-content-between py-2 mb-3"><span class="text-muted-gs">Questões no banco</span><b class="text-dark">{{ $topicos->sum('qtd_questoes') }}</b></div>
      <button class="btn btn-gs w-100" type="submit" name="acao" value="salvar">Criar ambiente</button>
      @if(session('rascunho_ambiente_id'))
        <button type="submit" form="form-cancelar-rascunho" class="btn btn-gs-ghost w-100 mt-2 text-danger">
          Cancelar e descartar rascunho
        </button>
      @else
        <a href="{{ route('ambientes.index') }}" class="btn btn-gs-ghost w-100 mt-2">Cancelar</a>
      @endif
    </div>
  </div>
</form>
@if(session('rascunho_ambiente_id'))
  <form id="form-cancelar-rascunho" action="{{ route('ambientes.cancelar', ['id' => session('rascunho_ambiente_id')]) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
  </form>
@endif
@endsection