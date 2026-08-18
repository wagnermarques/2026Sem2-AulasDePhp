<div class="page-header">
    <div>
        <h1 class="page-title">Visão Geral Financeira</h1>
        <p class="page-subtitle">Acompanhe suas receitas, despesas e saldo em tempo real</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Saldo Atual</span>
            <span class="stat-icon">💳</span>
        </div>
        <div class="stat-value <?= $saldo >= 0 ? 'text-success' : 'text-danger' ?>">
            R$ <?= number_format($saldo, 2, ',', '.') ?>
        </div>
        <div class="stat-meta">
            <?= $saldo >= 0 ? '🟢 Saldo Positivo' : '🔴 Atencao: Saldo Negativo' ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total de Receitas</span>
            <span class="stat-icon">📈</span>
        </div>
        <div class="stat-value text-success">
            R$ <?= number_format($totalReceitas, 2, ',', '.') ?>
        </div>
        <div class="stat-meta">Entradas no período</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total de Despesas</span>
            <span class="stat-icon">📉</span>
        </div>
        <div class="stat-value text-danger">
            R$ <?= number_format($totalDespesas, 2, ',', '.') ?>
        </div>
        <div class="stat-meta">Saídas no período</div>
    </div>
</div>

<div class="card mt-6">
    <div class="card-header">
        <h2>Comprometimento do Orçamento</h2>
        <span class="badge"><?= $percentualUso ?>% Usado</span>
    </div>
    <div class="progress-bar-container">
        <div class="progress-bar <?= $percentualUso > 80 ? 'bg-danger' : ($percentualUso > 50 ? 'bg-warning' : 'bg-success') ?>" 
             style="width: <?= min(100, $percentualUso) ?>%"></div>
    </div>
    <p class="text-muted text-sm mt-2">
        Suas despesas representam <strong><?= $percentualUso ?>%</strong> do total de receitas cadastradas.
    </p>
</div>

<div class="card mt-6">
    <div class="card-header">
        <h2>Últimas Transações</h2>
        <a href="/transacoes" class="btn btn-sm btn-secondary">Ver Todas &rarr;</a>
    </div>

    <?php if (empty($ultimasTransacoes)): ?>
        <p class="empty-state">Nenhuma transação cadastrada até o momento.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimasTransacoes as $t): ?>
                        <tr>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
