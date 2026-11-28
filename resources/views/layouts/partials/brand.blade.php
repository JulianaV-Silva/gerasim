{{-- Marca GeraSim. Passe 'dark' => true em fundo claro. --}}
<a href="{{ route('dashboard') }}" class="gs-brand {{ ($dark ?? false) ? 'gs-brand-dark p-0' : '' }}">
    @include('layouts.partials.logo') <span>GERA<span class="sim">SIM</span></span>
</a>
