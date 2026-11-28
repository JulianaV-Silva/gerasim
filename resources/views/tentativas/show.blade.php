@extends('layouts.app')

@section('title', 'Detalhes da tentativa')

@section('content')
<div class="gs-page-head">
  <div><div class="gs-eyebrow"><a href="{{ route('tentativas.index') }}">Histórico</a> / 20/11/2026</div><h1 class="gs-page-title">Revisão da Prova 1</h1></div>
  <a href="{{ route('simulados.resolver') }}" class="btn btn-gs"><x-icon name="refresh" />Refazer simulado</a>
</div>
<div class="row g-3">
  <div class="col-lg-4 order-lg-2">
    <div class="gs-card mb-3">
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Ambiente</span><b class="text-dark">Faculdade</b></div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Resultado</span><b class="gs-score">8/10 · 80%</b></div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted-gs">Tempo</span><b class="text-dark tnum">14:22</b></div>
      <div class="d-flex justify-content-between py-2"><span class="text-muted-gs">Iniciado</span><b class="text-dark tnum">20/11, 19:05</b></div>
    </div>
    <div class="gs-card">
      <h2 class="gs-card-title mb-2">Por tópico</h2>
      <x-topic-progress :value="100" display="5/5">Triggers</x-topic-progress>
      <x-topic-progress :value="67" display="2/3">Estr. de Dados</x-topic-progress>
      <x-topic-progress :value="50" display="1/2" weak>Funções</x-topic-progress>
    </div>
  </div>
  <div class="col-lg-8 order-lg-1">
    <div class="gs-pills mb-3" role="group" aria-label="Filtrar respostas"><button class="active">Todas (10)</button><button>Erradas (2)</button><button>Certas (8)</button></div>
    @php
    // Dados de exemplo. No backend, virão da tentativa (respostas_tentativa + questões + alternativas).
    $questoes = [
        ['topico' => 'Triggers', 'enunciado' => 'Qual comando é utilizado para criar uma trigger no PostgreSQL?', 'alternativas' => ['CREATE TRIGGER', 'ADD TRIGGER', 'NEW TRIGGER', 'MAKE TRIGGER'], 'correta' => 0, 'resposta' => 0],
        ['topico' => 'Triggers', 'enunciado' => 'Em uma trigger BEFORE UPDATE, qual variável contém os valores da linha depois da alteração?', 'alternativas' => ['OLD', 'NEW', 'CURRENT', 'ROW'], 'correta' => 1, 'resposta' => 1],
        ['topico' => 'Triggers', 'enunciado' => 'Uma trigger declarada com FOR EACH ROW é disparada:', 'alternativas' => ['Uma única vez por comando SQL', 'Uma vez para cada linha afetada', 'Apenas quando a tabela está vazia', 'Somente em comandos SELECT'], 'correta' => 1, 'resposta' => 1],
        ['topico' => 'Triggers', 'enunciado' => 'Qual é o tipo de retorno de uma função chamada por uma trigger?', 'alternativas' => ['RETURNS VOID', 'RETURNS RECORD', 'RETURNS TRIGGER', 'RETURNS TABLE'], 'correta' => 2, 'resposta' => 2],
        ['topico' => 'Triggers', 'enunciado' => 'Em uma trigger AFTER DELETE, qual registro está disponível com os dados removidos?', 'alternativas' => ['NEW', 'OLD', 'DELETED', 'LAST'], 'correta' => 1, 'resposta' => 1],
        ['topico' => 'Estrutura de Dados', 'enunciado' => 'Em uma pilha, qual elemento é removido primeiro?', 'alternativas' => ['O primeiro inserido', 'O último inserido', 'O menor elemento', 'Um elemento aleatório'], 'correta' => 1, 'resposta' => 1],
        ['topico' => 'Estrutura de Dados', 'enunciado' => 'Qual a complexidade da busca por um valor em uma lista encadeada não ordenada?', 'alternativas' => ['O(1)', 'O(log n)', 'O(n)', 'O(n²)'], 'correta' => 2, 'resposta' => 2],
        ['topico' => 'Estrutura de Dados', 'enunciado' => 'Em uma árvore binária de busca, qual percurso retorna os elementos em ordem crescente?', 'alternativas' => ['Pré-ordem', 'Em ordem (in-order)', 'Pós-ordem', 'Em largura'], 'correta' => 1, 'resposta' => 0],
        ['topico' => 'Funções', 'enunciado' => 'Em PL/pgSQL, qual bloco declara as variáveis de uma função?', 'alternativas' => ['VAR', 'LET', 'DECLARE', 'DEFINE'], 'correta' => 2, 'resposta' => 2],
        ['topico' => 'Funções', 'enunciado' => 'Qual opção informa ao PostgreSQL que a função sempre retorna o mesmo resultado para os mesmos argumentos?', 'alternativas' => ['STABLE', 'VOLATILE', 'STRICT', 'IMMUTABLE'], 'correta' => 3, 'resposta' => 0],
    ];
@endphp
<div class="d-flex flex-column gap-3" id="attempt-list">
    @foreach ($questoes as $i => $q)
        @php $acertou = $q['resposta'] === $q['correta']; @endphp
        <div class="gs-card" data-result="{{ $acertou ? 'right' : 'wrong' }}">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-2 flex-wrap">
                <h3 class="h6 m-0">Questão {{ $i + 1 }}</h3>
                <div class="d-flex gap-2">
                    <span class="gs-chip">{{ $q['topico'] }}</span>
                    <span class="gs-chip {{ $acertou ? 'gs-chip-ok' : 'gs-chip-bad' }}">{{ $acertou ? 'Acertou' : 'Errou' }}</span>
                </div>
            </div>
            <x-question :statement="$q['enunciado']" :alternatives="$q['alternativas']"
                        :correct="$q['correta']" :answer="$q['resposta']" review />
        </div>
    @endforeach
</div>

  </div>
</div>
@endsection
