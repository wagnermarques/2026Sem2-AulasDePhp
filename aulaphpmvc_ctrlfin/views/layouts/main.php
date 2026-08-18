<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'Controle Financeiro MVC') ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="container navbar-content">
            <a href="/" class="brand">
                <span class="brand-icon">💰</span>
                <span class="brand-text">FinCtrl <small>PHP 8.5 MVC</small></span>
            </a>
            <nav class="nav-links">
                <a href="/" class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/' ? 'active' : '') ?>">Dashboard</a>
                <a href="/transacoes" class="nav-link <?= (str_starts_with($_SERVER['REQUEST_URI'], '/transacoes') ? 'active' : '') ?>">Transações</a>
                <a href="/categorias" class="nav-link <?= (str_starts_with($_SERVER['REQUEST_URI'], '/categorias') ? 'active' : '') ?>">Categorias</a>
            </nav>
            <div class="nav-cta">
                <a href="/transacoes/criar" class="btn btn-primary">+ Nova Transação</a>
            </div>
        </div>
    </header>

    <main class="container main-content">
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger">
                ⚠️ <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>Projeto de Ensino <strong>MVC em PHP 8.5</strong> &copy; <?= date('Y') ?></p>
            <p class="tech-badge">Executando em Docker: <code>aula_nginx</code> • <code>aula_php8.5</code> • <code>aula_mariadb</code></p>
        </div>
    </footer>
</body>
</html>
