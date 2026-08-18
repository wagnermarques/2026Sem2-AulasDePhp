<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transacao;
use Core\Database;
use PDO;

class TransacaoRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * @return Transacao[]
     */
    public function buscarTodas(?string $tipo = null): array
    {
        $sql = "
            SELECT t.*, c.nome as nome_categoria, c.cor as cor_categoria 
            FROM transacoes t
            JOIN categorias c ON t.categoria_id = c.id
        ";

        $params = [];
        if ($tipo) {
            $sql .= " WHERE t.tipo = :tipo";
            $params['tipo'] = $tipo;
        }

        $sql .= " ORDER BY t.data_transacao DESC, t.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => Transacao::fromArray($row), $rows);
    }

    public function salvar(Transacao $transacao): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO transacoes (descricao, valor, tipo, categoria_id, data_transacao)
            VALUES (:descricao, :valor, :tipo, :categoria_id, :data_transacao)
        ");

        return $stmt->execute([
            'descricao'      => $transacao->descricao,
            'valor'          => $transacao->valor,
            'tipo'           => $transacao->tipo->value,
            'categoria_id'   => $transacao->categoriaId,
            'data_transacao' => $transacao->data->format('Y-m-d'),
        ]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM transacoes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function obterTotais(): array
    {
        $stmt = $this->db->query("
            SELECT 
                SUM(CASE WHEN tipo = 'receita' THEN valor ELSE 0 END) as total_receitas,
                SUM(CASE WHEN tipo = 'despesa' THEN valor ELSE 0 END) as total_despesas
            FROM transacoes
        ");

        $result = $stmt->fetch();
        return [
            'receitas' => (float)($result['total_receitas'] ?? 0),
            'despesas' => (float)($result['total_despesas'] ?? 0),
        ];
    }
}
