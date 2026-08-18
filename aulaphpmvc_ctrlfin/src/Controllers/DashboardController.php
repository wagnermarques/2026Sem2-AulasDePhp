<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransacaoRepository;
use App\Services\CalculadoraFinanceira;
use Core\Controller;
use Core\Request;

class DashboardController extends Controller
{
    private TransacaoRepository $transacaoRepo;
    private CalculadoraFinanceira $calculadora;

    public function __construct()
    {
        parent::__construct();
        $this->transacaoRepo = new TransacaoRepository();
        $this->calculadora = new CalculadoraFinanceira();
    }

    public function index(Request $request): void
    {
        $totais = $this->transacaoRepo->obterTotais();
        $saldo = $this->calculadora->calcularSaldo($totais['receitas'], $totais['despesas']);
        $percentual = $this->calculadora->calcularPercentualComprometido($totais['receitas'], $totais['despesas']);

        $ultimasTransacoes = array_slice($this->transacaoRepo->buscarTodas(), 0, 5);

        $this->render('dashboard/index', [
            'titulo'             => 'Visão Geral Financeira',
            'totalReceitas'      => $totais['receitas'],
            'totalDespesas'      => $totais['despesas'],
            'saldo'              => $saldo,
            'percentualUso'      => $percentual,
            'ultimasTransacoes'  => $ultimasTransacoes,
        ]);
    }
}
