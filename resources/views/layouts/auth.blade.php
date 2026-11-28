<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body>
    @include('layouts.partials.icons')
    <section class="gs-auth">
        <aside class="gs-auth-side">
            <a href="{{ route('home') }}" class="gs-brand">@include('layouts.partials.logo') <span>GERA<span class="sim">SIM</span></span></a>
            <h1>@yield('side_title')</h1>
            <p>@yield('side_text')</p>
            <ul>
                <li><span class="ck"><x-icon name="check" class="ic-sm" /></span>Simulados gerados a partir do seu conteúdo</li>
                <li><span class="ck"><x-icon name="check" class="ic-sm" /></span>Dashboard com sua evolução</li>
                <li><span class="ck"><x-icon name="check" class="ic-sm" /></span>Refaça os tópicos em que mais errou</li>
            </ul>
        </aside>
        <div class="gs-auth-form">
            @yield('content')
        </div>
    </section>
    @include('layouts.partials.scripts')
</body>
</html>
