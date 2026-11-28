<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SimuladoService
{
    public function __construct(
        private ApiService $api
    ) {}

    /**
     * RF004: Extrai os tópicos via IA e salva na tb_topico
     */
    public function salvarTopicosRevisados(
        int $idMaterial,
        array $topicos,
        bool $gerarQuestoes = false,
        ?string $caminhoArquivo = null
    ): void {
        $idsTopicosSalvos = [];

        DB::transaction(function () use ($idMaterial, $topicos, &$idsTopicosSalvos) {
            foreach ($topicos as $t) {
                $nome = mb_substr(trim($t['nm_topico']), 0, 100);
                if ($nome === '') {
                    continue;
                }

                $existe = DB::table('tb_topico')
                    ->whereRaw('LOWER(nm_topico) = ?', [mb_strtolower($nome)])
                    ->first();

                if ($existe) {
                    $idTopico = $existe->id_topico;
                } else {
                    $idTopico = DB::table('tb_topico')->insertGetId([
                        'nm_topico'    => $nome,
                        'ds_descricao' => $t['ds_descricao'] ?? '',
                    ]);
                }

                $idsTopicosSalvos[] = $idTopico;
            }

            DB::table('tb_material')
                ->where('id_material', $idMaterial)
                ->update(['fl_processamento' => true]);
        });

        if ($gerarQuestoes && $caminhoArquivo && !empty($idsTopicosSalvos)) {
            $material = DB::table('tb_material')->where('id_material', $idMaterial)->first();
            $qtdTotal = min(50, count($idsTopicosSalvos) * 5);

            $this->criarSimuladoComIA(
                idAmbiente: $material->id_ambiente,
                nmSimulado: 'Banco de Questões - ' . $material->nm_material,
                idsTopicos: $idsTopicosSalvos,
                caminhoArquivo: $caminhoArquivo,
                qtdQuestoes: $qtdTotal
            );
        }
    }

    /**
     * RF006 / RNF005 / RNF006: Reaproveita questões únicas existentes no banco
     * e gera com IA apenas o que faltar (com fallback caso a API esteja indisponível).
     */
    public function criarSimuladoComIA(
        int $idAmbiente,
        string $nmSimulado,
        array $idsTopicos,
        string $caminhoArquivo,
        int $qtdQuestoes
    ): int {
        $registrosTopicos = DB::table('tb_topico')
            ->whereIn('id_topico', $idsTopicos)
            ->get(['id_topico', 'nm_topico']);

        if ($registrosTopicos->isEmpty()) {
            throw new Exception("Nenhum tópico válido foi encontrado para gerar o simulado.");
        }

        // 1. Busca apenas 1 exemplar de cada enunciado distinto no banco para evitar questões duplicadas no mesmo simulado
        $idsUnicosPorEnunciado = DB::table('tb_questoes')
            ->select(DB::raw('MIN(id_questao) as id_questao'))
            ->whereIn('id_topico', $idsTopicos)
            ->groupBy('ds_enunciado');

        $questoesReaproveitadas = DB::table('tb_questoes')
            ->whereIn('id_questao', $idsUnicosPorEnunciado)
            ->inRandomOrder()
            ->limit($qtdQuestoes)
            ->get();

        $qtdFaltante = max(0, $qtdQuestoes - $questoesReaproveitadas->count());

        // 2. Se ainda faltam questões, chama a IA apenas para a diferença (com fallback para RNF006)
        $questoesGeradas = [];
        $mapaTopicos = [];

        if ($qtdFaltante > 0) {
            $nomesTopicos = [];
            foreach ($registrosTopicos as $t) {
                $mapaTopicos[mb_strtolower(trim($t->nm_topico))] = $t->id_topico;
                $nomesTopicos[] = $t->nm_topico;
            }

            try {
                $questoesGeradas = $this->api->gerarQuestoes($caminhoArquivo, $nomesTopicos, $qtdFaltante);
            } catch (Exception $e) {
                // RNF006: Se a API falhar mas já houver questões no banco, segue com o que tem
                if ($questoesReaproveitadas->isEmpty()) {
                    throw new Exception("A IA está indisponível no momento e não há questões salvas para os tópicos selecionados. Detalhe: " . $e->getMessage());
                }

                Log::warning("Fallback RNF006 ativado ao gerar simulado: " . $e->getMessage());
            }
        }

        // 3. Salva o simulado, replica as questões reaproveitadas e insere as novas geradas pela IA
        return DB::transaction(function () use (
            $idAmbiente,
            $nmSimulado,
            $idsTopicos,
            $questoesReaproveitadas,
            $questoesGeradas,
            $mapaTopicos
        ) {
            $totalReal = $questoesReaproveitadas->count() + count($questoesGeradas);

            $idSimulado = DB::table('tb_simulado')->insertGetId([
                'id_ambiente' => $idAmbiente,
                'nm_simulado' => mb_substr(trim($nmSimulado), 0, 100),
                'qtd_questoes' => $totalReal,
            ]);

            foreach (array_unique($idsTopicos) as $idTopico) {
                DB::table('tb_simulado_topico')->insert([
                    'id_simulado' => $idSimulado,
                    'id_topico' => $idTopico,
                ]);
            }

            // Reaproveita questões do banco vinculando-as ao novo simulado
            foreach ($questoesReaproveitadas as $qExistente) {
                $novoIdQuestao = DB::table('tb_questoes')->insertGetId([
                    'id_simulado' => $idSimulado,
                    'ds_enunciado' => $qExistente->ds_enunciado,
                    'id_topico' => $qExistente->id_topico,
                    'nu_peso' => $qExistente->nu_peso,
                ]);

                $alternativasOriginais = DB::table('tb_alternativas')
                    ->where('id_questao', $qExistente->id_questao)
                    ->get();

                $alternativas = $questao['alternativas']; 

                // Embaralha a ordem das 4 alternativas mantendo o vínculo de qual é a correta
                shuffle($alternativas);

                foreach ($alternativasOriginais as $altOrig) {
                    DB::table('tb_alternativas')->insert([
                        'id_questao' => $novoIdQuestao,
                        'ds_alternativa' => $altOrig->ds_alternativa,
                        'fl_correta' => (bool) $altOrig->fl_correta,
                    ]);
                }
            }

            // Insere as questões inéditas geradas pela IA
            foreach ($questoesGeradas as $q) {
                $chaveTopico = mb_strtolower(trim($q['nm_topico']));
                $idTopicoQuestao = $mapaTopicos[$chaveTopico] ?? $idsTopicos[0];
                $peso = max(1, min(3, (int) ($q['nu_peso'] ?? 1)));

                $idQuestao = DB::table('tb_questoes')->insertGetId([
                    'id_simulado' => $idSimulado,
                    'ds_enunciado' => $q['ds_enunciado'],
                    'id_topico' => $idTopicoQuestao,
                    'nu_peso' => $peso,
                ]);

                $temCorreta = false;
                foreach ($q['alternativas'] as $index => $alt) {
                    $correta = (bool) $alt['fl_correta'] && !$temCorreta;
                    if ($correta) {
                        $temCorreta = true;
                    }

                    if (!$temCorreta && $index === array_key_last($q['alternativas'])) {
                        $correta = true;
                    }

                    DB::table('tb_alternativas')->insert([
                        'id_questao' => $idQuestao,
                        'ds_alternativa' => $alt['ds_alternativa'],
                        'fl_correta' => $correta,
                    ]);
                }
            }

            return $idSimulado;
        });
    }
}