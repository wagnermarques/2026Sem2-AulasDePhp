<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Categoria;
use Core\Database;
use PDO;

class CategoriaRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * @return Categoria[]
     */
    public function buscarTodas(): array
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nome ASC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => Categoria::fromArray($row), $rows);
    }

    public function buscarPorId(int $id): ?Categoria
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? Categoria::fromArray($row) : null;
    }

    public function salvar(Categoria $categoria): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO categorias (nome, cor, tipo)
            VALUES (:nome, :cor, :tipo)
        ");

        return $stmt->execute([
            'nome' => $categoria->nome,
            'cor'  => $categoria->cor,
            'tipo' => $categoria->tipo->value,
        ]);
    }
}
