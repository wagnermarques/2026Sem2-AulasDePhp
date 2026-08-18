<?php

declare(strict_types=1);

namespace App\Services;

class CalculadoraFinanceira
{
    /**
     * Calcula o saldo líquido (Receitas - Despesas).
     */
    public function calcularSaldo(float $receitas, float $despesas): float
    {
        return $receitas - $despesas;
    }

    /**
     * Calcula a porcentagem do orçamento consumida pelas despesas.
     */
    public function calcularPercentualComprometido(float $receitas, float $despesas): float
    {
        if ($receitas <= 0) {
            return $despesas > 0 ? 100.0 : 0.0;
        }

        return min(100.0, round(($despesas / $receitas) * 100, 1));
    }
}
