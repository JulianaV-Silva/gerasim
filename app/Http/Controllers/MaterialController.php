<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\SimuladoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function __construct(
        private ApiService $api,
        private SimuladoService $simuladoService
    ) {}

    public function create(Request $request)
    {
        $ambientes = DB::table('tb_ambiente_estudo')->orderByDesc('id_ambiente')->get();
        $materiais = DB::table('tb_material')->orderByDesc('id_material')->limit(5)->get();
        $idAmbienteSelecionado = (int) $request->query('ambiente', $ambientes->first()->id_ambiente ?? 0);

        return view('materiais.create', compact('ambientes', 'materiais', 'idAmbienteSelecionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ambiente' => 'required|integer',
            'arquivos'    => 'required|array|min:1',
            'arquivos.*'  => 'file|mimes:pdf,txt,png,jpg,jpeg|max:20480',
        ]);

        $idAmbiente = (int) $request->input('id_ambiente');
        $topicosAgrupados = [];
        $ultimoIdMaterial = null;

        $idsLote = [];
        $nomesLote = [];

        foreach ($request->file('arquivos') as $arquivo) {
            $nomeMaterial = mb_substr($arquivo->getClientOriginalName(), 0, 60);
            $caminhoRelativo = $arquivo->store('materiais', 'public');
            $caminhoAbsoluto = Storage::disk('public')->path($caminhoRelativo);

            $existente = DB::table('tb_material')
                ->where('id_ambiente', $idAmbiente)
                ->whereRaw('LOWER(nm_material) = ?', [mb_strtolower($nomeMaterial)])
                ->first();

            if ($existente) {
                Storage::disk('public')->delete($existente->ds_caminho_arquivo);
                DB::table('tb_material')
                    ->where('id_material', $existente->id_material)
                    ->update([
                        'ds_caminho_arquivo' => $caminhoRelativo,
                        'fl_processamento'   => false,
                    ]);
                $idMaterial = $existente->id_material;
            } else {
                $idMaterial = DB::table('tb_material')->insertGetId([
                    'id_ambiente'        => $idAmbiente,
                    'nm_material'        => $nomeMaterial,
                    'ds_caminho_arquivo' => $caminhoRelativo,
                    'fl_processamento'   => false,
                ]);
            }

            $ultimoIdMaterial = $idMaterial;
            $idsLote[] = $idMaterial;      // <-- ADICIONADO AQUI
            $nomesLote[] = $nomeMaterial;  // <-- ADICIONADO AQUI

            try {
                $topicosDoArquivo = $this->api->extrairTopicos($caminhoAbsoluto);
                session(["topicos_sugeridos_{$idMaterial}" => $topicosDoArquivo]);
                $topicosAgrupados = array_merge($topicosAgrupados, $topicosDoArquivo);
            } catch (Exception $e) {
                return back()->with('erro', "Falha ao processar o arquivo {$nomeMaterial}: " . $e->getMessage());
            }
        }

        // <-- SUBSTITUÍDO AQUI (no lugar do session antigo)
        session([
            "topicos_sugeridos_{$ultimoIdMaterial}" => $topicosAgrupados,
            "lote_ids_{$ultimoIdMaterial}"          => $idsLote,
            "lote_nomes_{$ultimoIdMaterial}"        => implode(', ', $nomesLote),
        ]);

        return redirect()
            ->route('materiais.topicos', ['id' => $ultimoIdMaterial])
            ->with('sucesso', 'Materiais processados pela IA! Revise os tópicos sugeridos abaixo.');
    }

    public function topicos(int $id)
    {
        $material = DB::table('tb_material')->where('id_material', $id)->firstOrFail();
        $topicosSugeridos = session("topicos_sugeridos_{$id}", []);

        if (empty($topicosSugeridos) && Storage::disk('public')->exists($material->ds_caminho_arquivo)) {
            try {
                $caminhoAbsoluto = Storage::disk('public')->path($material->ds_caminho_arquivo);
                $topicosSugeridos = $this->api->extrairTopicos($caminhoAbsoluto);
                session(["topicos_sugeridos_{$id}" => $topicosSugeridos]);
            } catch (Exception $e) {
                session()->flash('erro', 'Não foi possível extrair os tópicos: ' . $e->getMessage());
            }
        }

        $tituloMateriais = session("lote_nomes_{$id}", $material->nm_material);
        $ambientes = DB::table('tb_ambiente_estudo')->get();

        return view('materiais.topicos', compact('material', 'topicosSugeridos', 'ambientes', 'tituloMateriais'));
    }

    public function salvarTopicos(Request $request, int $id)
    {
        $request->validate([
            'topicos'                => 'required|array|min:1',
            'topicos.*.nm_topico'    => 'required|string|max:100',
            'topicos.*.ds_descricao' => 'nullable|string',
        ]);

        $topicosSelecionados = array_filter(
            $request->input('topicos', []),
            fn($t) => !empty($t['selecionado'])
        );

        if (empty($topicosSelecionados)) {
            return back()->with('erro', 'Selecione pelo menos um tópico para salvar.');
        }

        $material = DB::table('tb_material')->where('id_material', $id)->firstOrFail();
        $caminhoAbsoluto = Storage::disk('public')->path($material->ds_caminho_arquivo);

        try {
            $this->simuladoService->salvarTopicosRevisados(
                idMaterial: $id,
                topicos: $topicosSelecionados,
                gerarQuestoes: $request->boolean('gerar_questoes'),
                caminhoArquivo: $caminhoAbsoluto
            );
        } catch (Exception $e) {
            return redirect()
                ->route('materiais.create', ['ambiente' => $material->id_ambiente])
                ->with('erro', $e->getMessage());
        }

        $idsLote = session()->pull("lote_ids_{$id}", [$id]);
        session()->forget(["topicos_sugeridos_{$id}", "lote_nomes_{$id}"]);

        DB::table('tb_material')
            ->whereIn('id_material', $idsLote)
            ->update(['fl_processamento' => true]);

        if (session()->has('retorno_apos_upload')) {
            $idAmbiente = session()->pull('retorno_apos_upload');
            $ambiente = DB::table('tb_ambiente_estudo')->where('id_ambiente', $idAmbiente)->first();

            return redirect()
                ->route('ambientes.create', ['retornando' => 1])
                ->withInput([
                    'nm_ambiente'  => $ambiente->nm_ambiente ?? '',
                    'ds_descricao' => $ambiente->ds_descricao ?? '',
                ])
                ->with('sucesso', 'Tópicos extraídos e adicionados! Finalize seu ambiente abaixo.');
        }

        return redirect()
            ->route('ambientes.index')
            ->with('sucesso', 'Tópicos salvos com sucesso no banco!');
    }
}