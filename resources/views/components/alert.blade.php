{{-- Alerta. Tipos: ok, info, warn, bad. Uso: <x-alert type="ok" icon="check">Texto</x-alert> --}}
@props(['type' => 'info', 'icon' => null])
@php
    $icon ??= ['ok' => 'check', 'info' => 'sparkles', 'warn' => 'alert', 'bad' => 'alert'][$type] ?? 'alert';
@endphp
<div {{ $attributes->merge(['class' => "gs-alert gs-alert-{$type}"]) }} role="{{ $type === 'bad' ? 'alert' : 'status' }}">
    <x-icon :name="$icon" />
    <div>{{ $slot }}</div>
</div>
