<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AmbienteController extends Controller
{
    public function index()
    {
        // Garante que qualquer rascunho abandonado ao navegar pelo menu seja descartado ou limpo da sessão
        session()->forget(['rascunho_ambiente_id', 'retorno_apos_upload', 'icone_rascunho']);

        $ambientes = DB::table('tb_ambiente_estudo')
            ->orderByDesc('id_ambiente')
            ->get()
            ->map(function ($amb) {
                $amb->qtd_simulados = DB::table('tb_simulado')
                    ->where('id_ambiente', $amb->id_ambiente)
                    ->count();

                $amb->qtd_materiais = DB::table('tb_material')
                    ->where('id_ambiente', $amb->id_ambiente)
                    ->count();

                return $amb;
            });

        $icones = json_decode(Storage::disk('local')->get('icones_ambientes.json') ?? '{}', true);

        return view('ambientes.index', compact('ambientes', 'icones'));
    }

    public function create(Request $request)
    {
        // Se NÃO veio do retorno do upload de material, limpa qualquer rascunho anterior da sessão
        if (!$request->boolean('retornando')) {
            session()->forget(['rascunho_ambiente_id', 'retorno_apos_upload', 'icone_rascunho']);
        }

        $topicos = DB::table('tb_topico')
            ->leftJoin('tb_questoes', 'tb_topico.id_topico', '=', 'tb_questoes.id_topico')
            ->select(
                'tb_topico.id_topico',
                'tb_topico.nm_topico',
                DB::raw('COUNT(DISTINCT tb_questoes.ds_enunciado) as qtd_questoes')
            )
            ->groupBy('tb_topico.id_topico', 'tb_topico.nm_topico')
            ->get();

        return view('ambientes.create', compact('topicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_ambiente'  => 'required|string|max:60',
            'ds_descricao' => 'nullable|string',
            'ds_icone'     => 'nullable|string|max:30',
        ]);

        $idUsuario = auth()->id() ?? DB::table('tb_usuario')->value('id_usuario');

        if (!$idUsuario) {
            $idUsuario = DB::table('tb_usuario')->insertGetId([
                'nm_usuario' => 'arthur.silva',
                'nm_email'   => 'arthur.silva@gerasim.com',
                'pwd_senha'  => sha1('123456'),
            ]);
        }

        $nomeLimpo = mb_substr(trim($request->input('nm_ambiente')), 0, 60);
        $idRascunho = session('rascunho_ambiente_id');
        $icone = $request->input('ds_icone', 'grad');

        // Valida se o mesmo usuário já possui outro ambiente com esse mesmo nome
        $jaExiste = DB::table('tb_ambiente_estudo')
            ->where('id_usuario', $idUsuario)
            ->whereRaw('LOWER(nm_ambiente) = ?', [mb_strtolower($nomeLimpo)])
            ->when($idRascunho, fn($query) => $query->where('id_ambiente', '!=', $idRascunho))
            ->exists();

        if ($jaExiste) {
            return back()
                ->withInput()
                ->withErrors(['nm_ambiente' => 'Você já possui um ambiente de estudo com este nome.']);
        }

        $dados = [
            'id_usuario'   => $idUsuario,
            'nm_ambiente'  => $nomeLimpo,
            'ds_descricao' => $request->input('ds_descricao'),
        ];

        // Atualiza o rascunho se estiver no meio do fluxo de upload, ou cria um novo registro único
        if ($idRascunho && DB::table('tb_ambiente_estudo')->where('id_ambiente', $idRascunho)->exists()) {
            DB::table('tb_ambiente_estudo')->where('id_ambiente', $idRascunho)->update($dados);
            $idAmbiente = $idRascunho;
        } else {
            $idAmbiente = DB::table('tb_ambiente_estudo')->insertGetId($dados);
        }

        // Salva o ícone escolhido vinculado ao ID do ambiente no JSON local
        $icones = json_decode(Storage::disk('local')->get('icones_ambientes.json') ?? '{}', true);
        $icones[$idAmbiente] = $icone;
        Storage::disk('local')->put('icones_ambientes.json', json_encode($icones));

        // Se clicou em "Enviar material", guarda o ID e o ícone como rascunho e vai para o upload
        if ($request->input('acao') === 'enviar_material') {
            session([
                'rascunho_ambiente_id' => $idAmbiente,
                'retorno_apos_upload'  => $idAmbiente,
                'icone_rascunho'       => $icone,
            ]);

            return redirect()
                ->route('materiais.create', ['ambiente' => $idAmbiente])
                ->with('sucesso', 'Rascunho salvo! Envie o material para extrair os tópicos.');
        }

        // Concluiu a criação: remove a marcação de rascunho e redireciona
        session()->forget(['rascunho_ambiente_id', 'retorno_apos_upload', 'icone_rascunho']);

        return redirect()
            ->route('ambientes.index')
            ->with('sucesso', 'Ambiente de estudo criado com sucesso!');
    }

    public function cancelarRascunho(int $id)
    {
        $materiais = DB::table('tb_material')->where('id_ambiente', $id)->get();
        foreach ($materiais as $mat) {
            Storage::disk('public')->delete($mat->ds_caminho_arquivo);
        }

        DB::table('tb_ambiente_estudo')->where('id_ambiente', $id)->delete();

        $this->removerIcone($id);
        session()->forget(['rascunho_ambiente_id', 'retorno_apos_upload', 'icone_rascunho']);

        return redirect()
            ->route('ambientes.index')
            ->with('sucesso', 'Criação cancelada e rascunho descartado.');
    }

    public function destroy(int $id)
    {
        $materiais = DB::table('tb_material')->where('id_ambiente', $id)->get();
        foreach ($materiais as $mat) {
            Storage::disk('public')->delete($mat->ds_caminho_arquivo);
        }

        DB::table('tb_ambiente_estudo')->where('id_ambiente', $id)->delete();

        $this->removerIcone($id);

        return redirect()
            ->route('ambientes.index')
            ->with('sucesso', 'Ambiente de estudo excluído com sucesso.');
    }

    private function removerIcone(int $id): void
    {
        $icones = json_decode(Storage::disk('local')->get('icones_ambientes.json') ?? '{}', true);
        if (isset($icones[$id])) {
            unset($icones[$id]);
            Storage::disk('local')->put('icones_ambientes.json', json_encode($icones));
        }
    }
}