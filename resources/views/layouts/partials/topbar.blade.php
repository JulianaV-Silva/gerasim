{{-- Barra superior: aparece só no celular, abre o menu lateral --}}
<div class="gs-topbar">
    @include('layouts.partials.brand', ['dark' => true])
    <button class="btn btn-gs-outline btn-icon" aria-label="Abrir menu" data-nav-open><x-icon name="menu" /></button>
</div>
