<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use Core\Controller;
use Core\Request;
use Exception;

class CategoriaController extends Controller
{
    private CategoriaRepository $categoriaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->categoriaRepo = new CategoriaRepository();
    }

    public function index(Request $request): void
    {
        $categorias = $this->categoriaRepo->buscarTodas();

        $this->render('categorias/index', [
            'titulo'     => 'Gerenciamento de Categorias',
            'categorias' => $categorias,
            'erro'       => null,
        ]);
    }

    public function salvar(Request $request): void
    {
        try {
            $nome = (string)$request->get('nome');
            $cor  = (string)$request->get('cor', '#6c757d');
            $tipo = (string)$request->get('tipo');

            if (empty($nome) || empty($tipo)) {
                throw new Exception('O nome e o tipo da categoria são obrigatórios.');
            }

            $categoria = Categoria::fromArray([
                'nome' => $nome,
                'cor'  => $cor,
                'tipo' => $tipo,
            ]);

            $this->categoriaRepo->salvar($categoria);
            $this->redirect('/categorias');
        } catch (Exception $e) {
            $categorias = $this->categoriaRepo->buscarTodas();
            $this->render('categorias/index', [
                'titulo'     => 'Gerenciamento de Categorias',
                'categorias' => $categorias,
                'erro'       => $e->getMessage(),
            ]);
        }
    }
}
