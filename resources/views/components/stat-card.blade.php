{{-- Card de número do dashboard. tone: '', t-blue, t-violet, t-indigo, t-soft --}}
@props(['label', 'icon', 'tone' => ''])
<div {{ $attributes->merge(['class' => 'gs-card gs-stat']) }}>
    <div class="gs-icon-tile {{ $tone }}"><x-icon :name="$icon" class="ic-lg" /></div>
    <div>
        <div class="lbl">{{ $label }}</div>
        <div class="val">{{ $slot }}</div>
    </div>
</div>
