{{-- Questão com alternativas.
     Modo resposta: <x-question :statement="..." :alternatives="[...]" name="q1" />
     Modo revisão:  <x-question ... :correct="0" :answer="2" review />  (mostra correta e resposta do usuário) --}}
@props(['statement', 'alternatives' => [], 'correct' => null, 'answer' => null, 'review' => false, 'name' => 'resposta'])
@php $letters = range('A', 'Z'); @endphp
<div {{ $attributes }}>
    <p class="{{ $review ? 'text-dark mb-3' : 'gs-q-statement mb-4' }}">{{ $statement }}</p>
    <div class="gs-alts" role="radiogroup">
        @foreach ($alternatives as $i => $text)
            @if ($review)
                @php $state = $i === $correct ? 'correct' : ($i === $answer ? 'wrong' : ''); @endphp
                <div class="gs-alt {{ $state }}" style="cursor:default">
                    <span class="letter">{{ $letters[$i] }}</span>{{ $text }}
                    @if ($i === $correct)
                        <span class="tag" style="color:var(--gs-ok)">Correta</span>
                    @elseif ($i === $answer)
                        <span class="tag" style="color:var(--gs-bad)">Sua resposta</span>
                    @endif
                </div>
            @else
                <label class="gs-alt {{ $i === $answer ? 'selected' : '' }}">
                    <input type="radio" class="visually-hidden" name="{{ $name }}" value="{{ $i }}" @checked($i === $answer)>
                    <span class="letter">{{ $letters[$i] }}</span>{{ $text }}
                </label>
            @endif
        @endforeach
    </div>
</div>
