<?php
namespace App\Services;

use Exception;

class ApiService {
    private string $apiKey;
    // Lista de modelos em ordem de preferência (se o primeiro der 503, tenta o próximo)
    private array $modelos = [
        'gemini-3.8-flash',
        'gemini-3.5-flash-lite',
        'gemini-2.5-flash',
        'gemini-2.5-flash-lite'
    ];

    public function __construct() {
        $this->apiKey = config('services.gemini_key');
    }

    private function enviarRequisicao(string $caminhoArquivo, string $prompt, array $responseSchema): array {
        set_time_limit(300); // Impede o Apache/XAMPP de cortar o script aos 30 segundos

        if (empty($this->apiKey)) {
            throw new Exception("Chave GEMINI_API_KEY não configurada no arquivo .env.");
        }

        if (!file_exists($caminhoArquivo)) {
            throw new Exception("Arquivo não encontrado: " . $caminhoArquivo);
        }

        $arquivoBase64 = base64_encode(file_get_contents($caminhoArquivo));
        $mimeType = mime_content_type($caminhoArquivo);

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "inline_data" => [
                                "mime_type" => $mimeType,
                                "data" => $arquivoBase64
                            ]
                        ],
                        [
                            "text" => $prompt
                        ]
                    ]
                ]
            ],
            "generationConfig" => [
                "responseMimeType" => "application/json",
                "responseSchema" => $responseSchema,
                "temperature" => 0.3
            ]
        ];

        $ultimoErro = '';

        // Tenta cada modelo da lista caso ocorra sobrecarga (HTTP 503) ou limite temporário (HTTP 429)
        foreach ($this->modelos as $modeloAtual) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modeloAtual}:generateContent?key={$this->apiKey}";

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 180
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($response === false) {
                throw new Exception("Falha de conexão com a API: " . $curlError);
            }

            $dadosApi = json_decode($response, true);

            // Se deu sucesso (200), processa e retorna imediatamente
            if ($httpCode === 200) {
                $textoJson = $dadosApi['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if (!$textoJson) {
                    throw new Exception("A IA não retornou conteúdo válido.");
                }

                $resultadoFinal = json_decode($textoJson, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Falha ao decodificar o JSON da IA: " . json_last_error_msg());
                }

                return $resultadoFinal;
            }

            $mensagemErro = $dadosApi['error']['message'] ?? 'Erro desconhecido';
            $ultimoErro = "Erro HTTP {$httpCode} ({$modeloAtual}): {$mensagemErro}";

            // Se for erro temporário de demanda (503) ou cota por minuto (429) ou modelo descontinuado (404), tenta o próximo modelo
            if (in_array($httpCode, [503, 429, 404])) {
                sleep(1);
                continue;
            }

            // Para outros erros (ex: chave inválida 400/403), interrompe na hora
            throw new Exception($ultimoErro);
        }

        throw new Exception("Todos os modelos estão indisponíveis no momento. Último erro: " . $ultimoErro);
    }

    /**
     * RF004: Extrai tópicos alinhados à tabela tb_topico (nm_topico, ds_descricao)
     */
    public function extrairTopicos(string $caminhoArquivo): array {
        $prompt = "Analise o material de estudo anexo e extraia os principais tópicos teóricos abordados. Seja objetivo nos nomes dos tópicos.";

        $schema = [
            "type" => "ARRAY",
            "items" => [
                "type" => "OBJECT",
                "properties" => [
                    "nm_topico" => ["type" => "STRING"],
                    "ds_descricao" => ["type" => "STRING"]
                ],
                "required" => ["nm_topico", "ds_descricao"]
            ]
        ];

        return $this->enviarRequisicao($caminhoArquivo, $prompt, $schema);
    }

    /**
     * RF006: Gera questões alinhadas às tabelas tb_questoes e tb_alternativas
     */
    public function gerarQuestoes(string $caminhoArquivo, array $topicosEscolhidos, int $qtdQuestoes): array {
        $listaTopicos = implode(", ", $topicosEscolhidos);

        $prompt = "Com base exclusivamente no material anexo, gere {$qtdQuestoes} questões de múltipla escolha cobrindo os seguintes tópicos: [{$listaTopicos}]. " .
                  "Cada questão deve ter exatamente 4 alternativas, sendo apenas 1 verdadeira (fl_correta = true). " .
                  "O campo 'nu_peso' deve ser um inteiro de 1 a 3 conforme a dificuldade da questão.".
                  "IMPORTANTE SOBRE AS ALTERNATIVAS:
                    - Varie aleatoriamente a posição da alternativa correta entre os índices 0, 1, 2 e 3 (letras A, B, C e D) ao longo das questões.
                    - Nunca coloque todas as respostas corretas na mesma posição (como sempre na primeira alternativa). Distribua de forma equilibrada entre A, B, C e D.
                    - Todas as alternativas devem ter tamanho e nível de detalhamento semelhantes para não entregar a resposta.";

        $schema = [
            "type" => "ARRAY",
            "items" => [
                "type" => "OBJECT",
                "properties" => [
                    "nm_topico" => ["type" => "STRING"],
                    "ds_enunciado" => ["type" => "STRING"],
                    "nu_peso" => ["type" => "INTEGER"],
                    "alternativas" => [
                        "type" => "ARRAY",
                        "items" => [
                            "type" => "OBJECT",
                            "properties" => [
                                "ds_alternativa" => ["type" => "STRING"],
                                "fl_correta" => ["type" => "BOOLEAN"]
                            ],
                            "required" => ["ds_alternativa", "fl_correta"]
                        ]
                    ]
                ],
                "required" => ["nm_topico", "ds_enunciado", "nu_peso", "alternativas"]
            ]
        ];

        return $this->enviarRequisicao($caminhoArquivo, $prompt, $schema);
    }
}