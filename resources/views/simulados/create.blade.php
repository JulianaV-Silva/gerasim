@extends('layouts.app')

@section('title', 'Criar simulado')

@section('content')
<div class="gs-page-head">
  <div>
    <div class="gs-eyebrow">
      <a href="{{ route('ambientes.show') }}">Faculdade</a> / Novo simulado</div>
      <h1 class="gs-page-title">Criar simulado</h1>
    </div>
  </div>
<form class="row g-3" onsubmit="event.preventDefault();window.location='{{ route('simulados.resolver') }}'">
  <div class="col-lg-8">
    <div class="gs-card mb-3">
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label" for="sim-name">Nome do simulado</label>
          <input id="sim-name" class="form-control" value="Revisão da Prova">
        </div>
        <div class="col-md-4">
          <label class="form-label" for="sim-total">Total de questões</label>
          <input id="sim-total" name="qtd_questoes" type="number" min="1" max="50" class="form-control tnum" value="{{ old('qtd_questoes', 5) }}" required oninput="atualizarResumo()">
        </div>
    </div>
    <div class="gs-card">
      <div class="gs-card-head mb-2">
        <div>
          <h2 class="gs-card-title">Tópicos</h2>
          <div class="small text-muted-gs">O número indica quantas questões já existem no banco.</div></div></div>
      <div class="gs-topic-pick my-3" id="sim-topics">
        @forelse($topicos as $t)
          <input type="checkbox" id="st{{ $t->id_topico }}" name="ids_topicos[]" value="{{ $t->id_topico }}" data-bank="{{ $t->qtd_banco }}" checked onchange="atualizarResumo()">
          <label for="st{{ $t->id_topico }}">
            <x-icon name="check" class="ic-sm tick" />{{ $t->nm_topico }} <span class="n">· {{ $t->qtd_banco }} no banco</span>
          </label>
        @empty
          <p class="small text-muted-gs">Nenhum tópico cadastrado ainda. <a href="{{ route('materiais.create') }}">Envie um material</a> primeiro.</p>
        @endforelse
      </div>
      <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" role="switch" id="sim-custom" checked><label class="form-check-label fw-semibold text-dark" for="sim-custom">Definir quantas questões por tópico</label></div>
      <div id="sim-dist" class="d-flex flex-column gap-2 mt-3"></div>
      <div id="sim-dist-alert" class="mt-3"></div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="gs-card position-sticky" style="top:1rem">
      <h2 class="gs-card-title mb-3">Como o simulado será montado</h2>
      <div class="d-flex align-items-center gap-3 mb-2">
        <div class="gs-icon-tile t-soft">
          <x-icon name="database" />
        </div>
        <div class="flex-grow-1">
          <div class="small text-muted-gs">Reaproveitadas do banco</div>
          <div class="gs-score fs-5" id="sum-reuse">0</div>
        </div>
      </div>
      <div class="d-flex align-items-center gap-3 mb-3">
        <div class="gs-icon-tile"><x-icon name="sparkles" /></div>
        <div class="flex-grow-1">
          <div class="small text-muted-gs">Novas, geradas pela IA</div>
          <div class="gs-score fs-5" id="sum-new">5</div>
        </div>
      </div>
      <div class="gs-bar mb-1" style="height:10px;background:#e9d9f8"><span id="sum-bar" style="width:70%;background:#6c6ad8"></span></div>
      <div class="small text-muted-gs mb-3" id="sum-note">A IA só é chamada para as questões que faltam no banco.</div>
      <button class="btn btn-gs w-100" type="submit" id="sim-submit">Gerar simulado</button>
      <a href="{{ route('ambientes.index') }}" class="btn btn-gs-ghost w-100 mt-2">Cancelar</a>
    </div>
  </div>
</form>

<script>
function atualizarResumo() {
  const total = parseInt(document.getElementById('sim-total').value) || 0;
  let bancoDisponivel = 0;
  document.querySelectorAll('#sim-topics input[type="checkbox"]:checked').forEach(cb => {
    bancoDisponivel += parseInt(cb.dataset.bank) || 0;
  });
  const reaproveitadas = Math.min(total, bancoDisponivel);
  const novasIa = Math.max(0, total - reaproveitadas);
  const pct = total > 0 ? Math.round((reaproveitadas / total) * 100) : 0;

  document.getElementById('sum-reuse').textContent = reaproveitadas;
  document.getElementById('sum-new').textContent = novasIa;
  document.getElementById('sum-bar').style.width = pct + '%';
}
document.addEventListener('DOMContentLoaded', atualizarResumo);
</script>
@endsection
