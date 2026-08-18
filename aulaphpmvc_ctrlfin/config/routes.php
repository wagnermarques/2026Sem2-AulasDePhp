<?php

declare(strict_types=1);

use App\Controllers\CategoriaController;
use App\Controllers\DashboardController;
use App\Controllers\TransacaoController;

/**
 * Tabela de Mapeamento de Rotas da Aplicação
 * Estrutura: 'MÉTODO HTTP /caminho' => [ControllerClass, 'nomeDoMetodo']
 */
return [
    'GET /' => [DashboardController::class, 'index'],
    
    // Rotas de Transações
    'GET /transacoes'        => [TransacaoController::class, 'index'],
    'GET /transacoes/criar'  => [TransacaoController::class, 'criar'],
    'POST /transacoes/salvar' => [TransacaoController::class, 'salvar'],
    'POST /transacoes/excluir' => [TransacaoController::class, 'excluir'],

    // Rotas de Categorias
    'GET /categorias'        => [CategoriaController::class, 'index'],
    'POST /categorias/salvar' => [CategoriaController::class, 'salvar'],
];
