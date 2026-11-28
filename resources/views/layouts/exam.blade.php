<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body>
    @include('layouts.partials.icons')
    <header class="gs-exam-top">
        @include('layouts.partials.brand', ['dark' => true])
        <div class="small text-muted-gs text-center text-truncate">Simulado · <b class="text-dark">@yield('exam_title')</b></div>
        <div class="d-flex gap-2 align-items-center">
            <span class="gs-timer"><x-icon name="clock" class="ic-sm" /><span id="ex-timer">00:00</span></span>
            <a href="@yield('exit_url')" class="btn btn-gs-outline btn-sm">Sair</a>
        </div>
    </header>
    @yield('content')
    @include('layouts.partials.scripts')
</body>
</html>
