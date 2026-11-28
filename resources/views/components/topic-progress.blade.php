{{-- Linha de desempenho por tópico. Uso: <x-topic-progress :value="82">Triggers</x-topic-progress>
     display: texto à direita (padrão "82%"). weak: destaca como ponto fraco. --}}
@props(['value' => 0, 'display' => null, 'weak' => false])
<div {{ $attributes->class(['gs-topic-row', 'is-weak' => $weak]) }}>
    <span>{{ $slot }}</span>
    <div class="gs-bar {{ $weak ? 'is-weak' : '' }}"><span style="width: {{ max(0, min(100, $value)) }}%"></span></div>
    <span class="pct">{{ $display ?? $value . '%' }}</span>
</div>
