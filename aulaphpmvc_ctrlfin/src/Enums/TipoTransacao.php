<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoTransacao: string
{
    case RECEITA = 'receita';
    case DESPESA = 'despesa';

    public function rotulo(): string
    {
        return match($this) {
            self::RECEITA => 'Receita (+)',
            self::DESPESA => 'Despesa (-)',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::RECEITA => 'badge-sucesso',
            self::DESPESA => 'badge-perigo',
        };
    }

    public function classeBadge(): string
    {
        return $this->badgeClass();
    }
}
