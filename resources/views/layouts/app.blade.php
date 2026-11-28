<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body>
    @include('layouts.partials.icons')
    @include('layouts.partials.sidebar')

    <main class="gs-main">
        @include('layouts.partials.topbar')

        @if (session('success'))
            <x-alert type="ok" class="mb-3">{{ session('success') }}</x-alert>
        @endif
        @if ($errors->any())
            <x-alert type="bad" class="mb-3">{{ $errors->first() }}</x-alert>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.scripts')
</body>
</html>
