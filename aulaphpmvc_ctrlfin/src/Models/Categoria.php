<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TipoTransacao;

class Categoria
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nome,
        public readonly string $cor,
        public readonly TipoTransacao $tipo
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            nome: (string)$data['nome'],
            cor: $data['cor'] ?? '#6c757d',
            tipo: TipoTransacao::from($data['tipo'])
        );
    }
}
