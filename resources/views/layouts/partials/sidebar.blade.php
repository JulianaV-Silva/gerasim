<nav class="gs-sidebar" aria-label="Menu principal">
    @include('layouts.partials.brand')
    <ul class="gs-nav">
        <li><a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])><x-icon name="chart" />Dashboard</a></li>
        <li><a href="{{ route('ambientes.index') }}" @class(['active' => request()->routeIs('ambientes.*', 'simulados.*', 'tentativas.resultado')])><x-icon name="grid" />Meus ambientes</a></li>
        <li class="gs-nav-label">Conteúdo</li>
        <li><a href="{{ route('disciplinas.index') }}" @class(['active' => request()->routeIs('disciplinas.*', 'materiais.*')])><x-icon name="book" />Disciplinas e materiais</a></li>
        <li><a href="{{ route('questoes.index') }}" @class(['active' => request()->routeIs('questoes.*')])><x-icon name="list" />Banco de questões</a></li>
        <li class="gs-nav-label">Prática</li>
        <li><a href="{{ route('tentativas.index') }}" @class(['active' => request()->routeIs('tentativas.index', 'tentativas.show')])><x-icon name="history" />Histórico</a></li>
    </ul>
    <div class="gs-user">
        {{-- Trocar pelos dados de auth()->user() quando a autenticação estiver pronta --}}
        <div class="gs-avatar">AS</div>
        <div class="flex-grow-1 lh-sm" style="min-width:0">
            <div class="fw-semibold">Arthur Silva</div>
            <small class="d-block text-truncate" style="color:#aeb0e6">arthur.silva@email.com</small>
        </div>
        <a href="{{ route('login') }}" class="btn btn-icon" style="color:#cfd0f3" title="Sair" aria-label="Sair"><x-icon name="logout" /></a>
    </div>
</nav>
<div class="gs-backdrop" data-nav-close></div>
