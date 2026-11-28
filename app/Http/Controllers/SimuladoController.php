<?php

namespace App\Http\Controllers;

use App\Services\SimuladoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SimuladoController extends Controller
{
    public function __construct(
        private SimuladoService $simuladoService
    ) {}

    public function create(Request $request)
    {
        $ambientes = DB::table('tb_ambiente_estudo')->get();
        $idAmbiente = $request->query('ambiente', $ambientes->first()->id_ambiente ?? 1);

        // Lista tópicos e conta quantas questões já existem no banco para cada tópico
        $topicos = DB::table('tb_topico')
            ->leftJoin('tb_questoes', 'tb_topico.id_topico', '=', 'tb_questoes.id_topico')
            ->select('tb_topico.id_topico', 'tb_topico.nm_topico', DB::raw('COUNT(DISTINCT tb_questoes.ds_enunciado) as qtd_banco'))
            ->groupBy('tb_topico.id_topico', 'tb_topico.nm_topico')
            ->get();

        $materiais = DB::table('tb_material')
            ->where('id_ambiente', $idAmbiente)
            ->get();

        return view('simulados.create', compact('ambientes', 'idAmbiente', 'topicos', 'materiais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ambiente'  => 'required|integer',
            'id_material'  => 'required|integer',
            'nm_simulado'  => 'required|string|max:100',
            'ids_topicos'  => 'required|array|min:1',
            'ids_topicos.*'=> 'integer',
            'qtd_questoes' => 'required|integer|min:1|max:50',
        ]);

        $material = DB::table('tb_material')
        ->where('id_material', $request->input('id_material'))
        ->where('id_ambiente', $request->input('id_ambiente'))
        ->first();
        
        if (!$material) {
            return back()->withErrors(['id_material' => 'Selecione um material válido para basear a geração via IA.']);
        }

        $caminhoAbsoluto = Storage::disk('public')->path($material->ds_caminho_arquivo);

        try {
            $idSimulado = $this->simuladoService->criarSimuladoComIA(
                idAmbiente: (int) $request->input('id_ambiente'),
                nmSimulado: $request->input('nm_simulado'),
                idsTopicos: $request->input('ids_topicos'),
                caminhoArquivo: $caminhoAbsoluto,
                qtdQuestoes: (int) $request->input('qtd_questoes')
            );

            return redirect()
                ->route('simulados.resolver', ['id' => $idSimulado])
                ->with('sucesso', 'Simulado gerado com sucesso!');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('erro', 'Não foi possível gerar o simulado agora: ' . $e->getMessage());
        }
    }

    public function resolver(int $id)
    {
        $simulado = DB::table('tb_simulado')->where('id_simulado', $id)->firstOrFail();

        $questoes = DB::table('tb_questoes')
            ->join('tb_topico', 'tb_questoes.id_topico', '=', 'tb_topico.id_topico')
            ->where('tb_questoes.id_simulado', $id)
            ->select('tb_questoes.*', 'tb_topico.nm_topico')
            ->get()
            ->map(function ($q) {
                $q->alternativas = DB::table('tb_alternativas')
                    ->where('id_questao', $q->id_questao)
                    ->get();
                return $q;
            });

        return view('simulados.resolver', compact('simulado', 'questoes'));
    }
}