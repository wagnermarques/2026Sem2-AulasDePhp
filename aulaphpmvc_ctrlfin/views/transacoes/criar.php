<div class="page-header">
    <div>
        <h1 class="page-title">Cadastrar Nova Transação</h1>
        <p class="page-subtitle">Preencha os campos abaixo para registrar uma movimentação</p>
    </div>
    <div>
        <a href="/transacoes" class="btn btn-secondary">&larr; Voltar para Lista</a>
    </div>
</div>

<div class="card max-w-2xl mt-4">
    <form action="/transacoes/salvar" method="POST" class="form-grid">
        <div class="form-group">
            <label for="descricao" class="form-label">Descrição *</label>
            <input type="text" id="descricao" name="descricao" class="form-input" placeholder="Ex: Salário Mensal, Supermercado" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="valor" class="form-label">Valor (R$) *</label>
                <input type="number" step="0.01" min="0.01" id="valor" name="valor" class="form-input" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="tipo" class="form-label">Tipo de Transação *</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="receita">Receita (+)</option>
                    <option value="despesa">Despesa (-)</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="categoria_id" class="form-label">Categoria *</label>
                <select id="categoria_id" name="categoria_id" class="form-select" required>
                    <option value="">Selecione uma categoria...</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat->id ?>">
                            [<?= strtoupper($cat->tipo->value) ?>] <?= htmlspecialchars($cat->nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="data_transacao" class="form-label">Data da Transação *</label>
                <input type="date" id="data_transacao" name="data_transacao" class="form-input" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="form-actions mt-4">
            <button type="submit" class="btn btn-primary">Salvar Transação</button>
            <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
