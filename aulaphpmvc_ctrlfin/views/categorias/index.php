<div class="page-header">
    <div>
        <h1 class="page-title">Categorias Financeiras</h1>
        <p class="page-subtitle">Organize suas despesas e receitas por categorias customizadas</p>
    </div>
</div>

<div class="grid-2-cols mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Nova Categoria</h2>
        </div>
        <form action="/categorias/salvar" method="POST" class="form-grid">
            <div class="form-group">
                <label for="nome" class="form-label">Nome da Categoria *</label>
                <input type="text" id="nome" name="nome" class="form-input" placeholder="Ex: Investimentos, Educação" required>
            </div>

            <div class="form-group">
                <label for="tipo" class="form-label">Tipo *</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="receita">Receita</option>
                    <option value="despesa">Despesa</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cor" class="form-label">Cor de Identificação</label>
                <input type="color" id="cor" name="cor" class="form-color" value="#3b82f6">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Categoria</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Categorias Cadastradas</h2>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cor</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td>
                                <span class="color-badge" style="background-color: <?= htmlspecialchars($cat->cor) ?>"></span>
                            </td>
                            <td><strong><?= htmlspecialchars($cat->nome) ?></strong></td>
                            <td>
                                <span class="badge <?= $cat->tipo === App\Enums\TipoTransacao::RECEITA ? 'badge-sucesso' : 'badge-perigo' ?>">
                                    <?= ucfirst($cat->tipo->value) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
