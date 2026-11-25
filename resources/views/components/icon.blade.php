{{-- Ícone do sprite Lucide (layouts/partials/icons). Uso: <x-icon name="plus" class="ic-sm" /> --}}
@props(['name'])
<svg {{ $attributes->merge(['class' => 'ic']) }} aria-hidden="true"><use href="#i-{{ $name }}"/></svg>
