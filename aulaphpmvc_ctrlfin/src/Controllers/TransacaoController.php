<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\TipoTransacao;
use App\Models\Transacao;
use App\Repositories\CategoriaRepository;
use App\Repositories\TransacaoRepository;
use Core\Controller;
use Core\Request;
use Exception;

class TransacaoController extends Controller
{
    private TransacaoRepository $transacaoRepo;
    private CategoriaRepository $categoriaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->transacaoRepo = new TransacaoRepository();
        $this->categoriaRepo = new CategoriaRepository();
    }

    public function index(Request $request): void
    {
        $tipoFiltro = $request->get('tipo');
        $transacoes = $this->transacaoRepo->buscarTodas($tipoFiltro);

        $this->render('transacoes/index', [
            'titulo'      => 'Listagem de Transações',
            'transacoes'  => $transacoes,
            'tipoFiltro'  => $tipoFiltro,
        ]);
    }

    public function criar(Request $request): void
    {
        $categorias = $this->categoriaRepo->buscarTodas();

        $this->render('transacoes/criar', [
            'titulo'     => 'Nova Transação',
            'categorias' => $categorias,
            'erro'       => null,
        ]);
    }

    public function salvar(Request $request): void
    {
        try {
            $descricao   = (string)$request->get('descricao');
            $valor       = (float)$request->get('valor');
            $tipo        = (string)$request->get('tipo');
            $categoriaId = (int)$request->get('categoria_id');
            $data        = (string)$request->get('data_transacao');

            if (empty($descricao) || $valor <= 0 || !$categoriaId || empty($data)) {
                throw new Exception('Preencha todos os campos obrigatórios com valores válidos.');
            }

            $transacao = Transacao::fromArray([
                'descricao'      => $descricao,
                'valor'          => $valor,
                'tipo'           => $tipo,
                'categoria_id'   => $categoriaId,
                'data_transacao' => $data,
            ]);

            $this->transacaoRepo->salvar($transacao);
            $this->redirect('/transacoes');
        } catch (Exception $e) {
            $categorias = $this->categoriaRepo->buscarTodas();
            $this->render('transacoes/criar', [
                'titulo'     => 'Nova Transação',
                'categorias' => $categorias,
                'erro'       => $e->getMessage(),
            ]);
        }
    }

    public function excluir(Request $request): void
    {
        $id = (int)$request->get('id');
        if ($id > 0) {
            $this->transacaoRepo->excluir($id);
        }

        $this->redirect('/transacoes');
    }
}
