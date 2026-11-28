<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestaoController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('tb_questoes')
            ->join('tb_topico', 'tb_questoes.id_topico', '=', 'tb_topico.id_topico')
            ->leftJoin('tb_simulado', 'tb_questoes.id_simulado', '=', 'tb_simulado.id_simulado')
            ->leftJoin('tb_ambiente_estudo', 'tb_simulado.id_ambiente', '=', 'tb_ambiente_estudo.id_ambiente')
            ->select(
                'tb_questoes.*',
                'tb_topico.nm_topico',
                'tb_ambiente_estudo.nm_ambiente'
            );

        if ($request->filled('busca')) {
            $query->where('tb_questoes.ds_enunciado', 'like', '%' . $request->input('busca') . '%');
        }

        if ($request->filled('disciplina')) {
            $query->where('tb_ambiente_estudo.id_ambiente', $request->input('disciplina'));
        }

        if ($request->filled('topico')) {
            $query->where('tb_questoes.id_topico', $request->input('topico'));
        }

        if ($request->input('origem') === 'ia') {
            $query->whereNotNull('tb_questoes.id_simulado');
        } elseif ($request->input('origem') === 'manual') {
            $query->whereNull('tb_questoes.id_simulado');
        }

        $questoes = $query
            ->orderByDesc('tb_questoes.id_questao')
            ->paginate(10)
            ->withQueryString();

        // Busca todas as alternativas das questões desta página e agrupa por id_questao
        $idsQuestoes = $questoes->pluck('id_questao')->all();
        $alternativasPorQuestao = DB::table('tb_alternativas')
            ->whereIn('id_questao', $idsQuestoes)
            ->orderBy('id_alternativa')
            ->get()
            ->groupBy('id_questao');

        $ambientes = DB::table('tb_ambiente_estudo')->orderBy('nm_ambiente')->get();
        $topicos = DB::table('tb_topico')->orderBy('nm_topico')->get();

        $topicoSelecionado = $request->filled('topico')
            ? $topicos->firstWhere('id_topico', (int) $request->input('topico'))?->nm_topico
            : 'todos os tópicos';

        return view('questoes.index', compact(
            'questoes',
            'alternativasPorQuestao',
            'ambientes',
            'topicos',
            'topicoSelecionado'
        ));
    }
}