# 📊 Plano de Ensino: Arquitetura MVC com PHP 8.5+ (Controle Financeiro Pessoal)

Este projeto foi desenhado especificamente para **ensinar os conceitos de MVC (Model-View-Controller)** do zero, sem o uso de frameworks pesados (como Laravel ou Symfony). O objetivo é desmistificar como um framework web funciona por baixo dos panos usando recursos modernos do **PHP 8.4 e 8.5**.

---

## 🎯 1. Objetivos Pedagógicos

Ao concluir este projeto, os alunos serão capazes de:
1. **Compreender a Separabilidade de Responsabilidades**: Entender por que misturar regras de negócio, consultas SQL e HTML resulta em código frágil e de difícil manutenção.
2. **Implementar o Padrão Front Controller & Roteamento**: Entender a função do `public/index.php` e como a URL é mapeada para Controllers e Métodos.
3. **Desenvolver a Camada Model**: Criar Entidades tipadas, Repositories e consultas seguras com PDO (Prepared Statements) para MySQL/MariaDB.
4. **Construir a Camada View**: Renderizar templates dinâmicos, reaproveitar Layouts (`main.php`) e tratar sanitização contra XSS (`htmlspecialchars`).
5. **Desenvolver a Camada Controller**: Capturar a requisição (Request), validar dados, interagir com o Model e devolver respostas (Render ou Redirecionamento).
6. **Dominar Funcionalidades Modernas do PHP 8.4/8.5**:
   - `declare(strict_types=1);`
   - Asymmetric Visibility (`public private(set) string $descricao`)
   - Property Hooks (`get => $this->_valor; set { ... }` nas propriedades de classe)
   - Enums nativos (`TipoTransacao` com receitas e despesas)
   - Expressões `match` para rotulagem e estilização dinâmica
   - Promoção de propriedades no construtor
   - Readonly classes e propriedades

---

## 📁 2. Estrutura de Diretórios Recomendada

```text
aulaphpmvc_ctrlfin/
├── config/
│   ├── database.php          # Configuração de conexão PDO (MySQL / MariaDB)
│   └── routes.php            # Tabela de rotas (Método HTTP + URI -> Controller@acao)
├── core/                     # Micro-framework educacional criado pelos alunos
│   ├── Controller.php        # Controller base (renderização de views e redirecionamento)
│   ├── Database.php          # Gerenciador singleton PDO para MariaDB/MySQL
│   ├── Request.php           # Wrapper HTTP para $_GET, $_POST e $_SERVER
│   ├── Response.php          # Helper de respostas e cabeçalhos HTTP
│   └── Router.php            # Processador e combinador de rotas com regex
├── src/                      # Regras de Negócio e Aplicação (Domain & MVC)
│   ├── Controllers/
│   │   ├── CategoriaController.php
│   │   ├── DashboardController.php
│   │   └── TransacaoController.php
│   ├── Enums/
│   │   └── TipoTransacao.php  # Receita, Despesa
│   ├── Models/
│   │   ├── Categoria.php
│   │   └── Transacao.php
│   ├── Repositories/
│   │   ├── CategoriaRepository.php
│   │   └── TransacaoRepository.php
│   └── Services/
│       └── CalculadoraFinanceira.php # Serviço de domínio para calcular saldos e totais
├── views/
│   ├── layouts/
│   │   └── main.php          # Layout base (Cabeçalho, Menu, Footer e Toast messages)
│   ├── dashboard/
│   │   └── index.php         # Resumo com cards de saldo, receitas, despesas e gráfico
│   ├── transacoes/
│   │   ├── index.php         # Listagem e filtros de transações
│   │   └── criar.php         # Formulário de nova transação
│   └── categorias/
│       └── index.php         # Gestão de categorias
├── public/
│   ├── index.php             # Front Controller (Ponto único de entrada)
│   └── css/                  # Estilos CSS modernos da interface
├── database/
│   ├── schema.sql            # Script SQL de criação das tabelas no MariaDB
│   └── seed.sql              # Dados iniciais para testes (categorias e transações)
├── docker-compose.yml        # Orquestração dos serviços aula_nginx, aula_php8.5, aula_mariadb
├── composer.json             # Autoloading PSR-4 (App\\ -> src/, Core\\ -> core/)
├── TUTORIAL_EXECUCAO_WINDOWS.md # Guia para alunos no Windows
├── TUTORIAL_EXECUCAO_FEDORA.md  # Guia para o professor no Fedora
└── PLANO_DE_AULA_MVC_PHP8.5.md  # Este arquivo
```

---

## 💎 3. Destacando Recursos do PHP 8.4 / 8.5 no Código

### A. Visibilidade Assimétrica (`private(set)`) & Property Hooks
Exemplo na Entidade `Transacao` (`src/Models/Transacao.php`):

```php
<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TipoTransacao;
use DateTimeImmutable;
use InvalidArgumentException;

class Transacao
{
    private float $_valor = 0.0;

    // PHP 8.5 Property Hook para validação estrita no set e leitura no get
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
        // Asymmetric Visibility (PHP 8.4/8.5): Leitura pública, gravação estrita
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
}
```

### B. Backed Enums e Expressões `match`
Exemplo no Enum `TipoTransacao` (`src/Enums/TipoTransacao.php`):

```php
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

    public function classeBadge(): string
    {
        return match($this) {
            self::RECEITA => 'badge-sucesso',
            self::DESPESA => 'badge-perigo',
        };
    }
}
```

---

## 🗄️ 4. Modelagem do Banco de Dados (MariaDB / MySQL)

```sql
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `cor` VARCHAR(7) NOT NULL DEFAULT '#6c757d',
    `tipo` ENUM('receita', 'despesa') NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `transacoes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `descricao` VARCHAR(255) NOT NULL,
    `valor` DECIMAL(10, 2) NOT NULL,
    `tipo` ENUM('receita', 'despesa') NOT NULL,
    `categoria_id` INT NOT NULL,
    `data_transacao` DATE NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_transacoes_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🚀 5. Roteiro Passo a Passo das Aulas (Pedagogia)

1. **Módulo 1: O Problema do PHP Espaguete**
   - Discutir como código legado misturava PDO SQL, HTML e formulários em um único arquivo `.php`.
2. **Módulo 2: O Ponto de Entrada Único (Front Controller & Autoloading)**
   - Explicar a função do `public/index.php`, reescritas de URL no Nginx e autoloading PSR-4 via Composer.
3. **Módulo 3: O Motor do Framework (`core/`)**
   - Estudar as classes `Request`, `Response`, `Router` e `Controller` base.
4. **Módulo 4: A Camada de Dados (PDO + Enums + Models PHP 8.5)**
   - Conectar ao MariaDB no `core/Database.php`. Desenvolver modelos com Property Hooks e Repositories parametrizados.
5. **Módulo 5: Controllers e Views**
   - Desenvolver o `DashboardController`, renderizando dados dinâmicos dentro do layout `views/layouts/main.php`.
6. **Módulo 6: Formulários, Validações e Redirecionamentos**
   - Criar formulários de nova transação com tratamento de exceções e sanitização contra XSS.
7. **Módulo 7: Painel Financeiro e Métricas**
   - Exibir balanço líquido, cálculo do percentual do orçamento consumido e histórico de movimentações.
