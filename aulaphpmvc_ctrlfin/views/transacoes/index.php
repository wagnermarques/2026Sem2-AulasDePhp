<div class="page-header">
    <div>
        <h1 class="page-title">Transações Financeiras</h1>
        <p class="page-subtitle">Gerencie suas entradas e saídas de caixa</p>
    </div>
    <div>
        <a href="/transacoes/criar" class="btn btn-primary">+ Adicionar Transação</a>
    </div>
</div>

<div class="filter-bar">
    <span>Filtrar por:</span>
    <a href="/transacoes" class="filter-chip <?= empty($tipoFiltro) ? 'active' : '' ?>">Todas</a>
    <a href="/transacoes?tipo=receita" class="filter-chip <?= $tipoFiltro === 'receita' ? 'active' : '' ?>">Receitas</a>
    <a href="/transacoes?tipo=despesa" class="filter-chip <?= $tipoFiltro === 'despesa' ? 'active' : '' ?>">Despesas</a>
</div>

<div class="card mt-4">
    <?php if (empty($transacoes)): ?>
        <p class="empty-state">Nenhuma transação encontrada com os filtros selecionados.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th class="text-right">Valor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transacoes as $t): ?>
                        <tr>
                            <td>#<?= $t->id ?></td>
                            <td><strong><?= htmlspecialchars($t->descricao) ?></strong></td>
                            <td>
                                <span class="category-pill" style="background-color: <?= htmlspecialchars($t->corCategoria ?? '#6c757d') ?>">
                                    <?= htmlspecialchars($t->nomeCategoria ?? 'Geral') ?>
                                </span>
                            </td>
                            <td><?= $t->data->format('d/m/Y') ?></td>
                            <td>
                                <span class="badge <?= $t->tipo->classeBadge() ?>">
                                    <?= $t->tipo->rotulo() ?>
                                </span>
                            </td>
                            <td class="text-right <?= $t->tipo === App\Enums\TipoTransacao::RECEITA ? 'text-success' : 'text-danger' ?>">
                                <strong>
                                    <?= $t->tipo === App\Enums\TipoTransacao::RECEITA ? '+' : '-' ?> 
                                    R$ <?= number_format($t->valor, 2, ',', '.') ?>
                                </strong>
                            </td>
                            <td class="text-center">
                                <form action="/transacoes/excluir" method="POST" onsubmit="return confirm('Deseja realmente remover esta transação?');">
                                    <input type="hidden" name="id" value="<?= $t->id ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
