<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TipoTransacao;
use DateTimeImmutable;
use InvalidArgumentException;

class Transacao
{
    private float $_valor = 0.0;

    /**
     * Exemplo de Property Hook (PHP 8.5) para validação estrita no set e leitura no get.
     */
    public float $valor {
        get => $this->_valor;
        set {
            if ($value <= 0) {
                throw new InvalidArgumentException('O valor da transação deve ser estritamente positivo.');
            }
            $this->_valor = $value;
        }
    }

    public function __construct(
        public readonly ?int $id,
        // Exemplo de Visibilidade Assimétrica (private(set)) do PHP 8.4/8.5
        public private(set) string $descricao,
        float $valor,
        public private(set) TipoTransacao $tipo,
        public private(set) int $categoriaId,
        public private(set) DateTimeImmutable $data,
        public readonly ?string $nomeCategoria = null,
        public readonly ?string $corCategoria = null
    ) {
        $this->valor = $valor;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            descricao: (string)$data['descricao'],
            valor: (float)$data['valor'],
            tipo: is_string($data['tipo']) ? TipoTransacao::from($data['tipo']) : $data['tipo'],
            categoriaId: (int)$data['categoria_id'],
            data: new DateTimeImmutable($data['data_transacao'] ?? 'now'),
            nomeCategoria: $data['nome_categoria'] ?? null,
            corCategoria: $data['cor_categoria'] ?? null
        );
    }
}
