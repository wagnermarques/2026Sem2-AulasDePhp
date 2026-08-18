-- Categorias de Receitas e Despesas Padrão
INSERT INTO `categorias` (`id`, `nome`, `cor`, `tipo`) VALUES
(1, 'Salário & Remuneração', '#10b981', 'receita'),
(2, 'Investimentos & Rendimentos', '#06b6d4', 'receita'),
(3, 'Freelance & Serviços', '#3b82f6', 'receita'),
(4, 'Alimentação & Supermercado', '#f59e0b', 'despesa'),
(5, 'Moradia & Aluguel', '#ef4444', 'despesa'),
(6, 'Transporte & Combustível', '#8b5cf6', 'despesa'),
(7, 'Lazer & Entretenimento', '#ec4899', 'despesa'),
(8, 'Saúde & Cuidados', '#14b8a6', 'despesa');

-- Transações Iniciais de Exemplo
INSERT INTO `transacoes` (`descricao`, `valor`, `tipo`, `categoria_id`, `data_transacao`) VALUES
('Salário Mensal - Empresa XYZ', 5500.00, 'receita', 1, CURRENT_DATE()),
('Rendimento de Dividendos', 320.50, 'receita', 2, CURRENT_DATE()),
('Projeto Web Freelance', 1200.00, 'receita', 3, CURRENT_DATE()),
('Compras do Mês - Supermercado', 850.40, 'despesa', 4, CURRENT_DATE()),
('Aluguel e Condomínio', 1800.00, 'despesa', 5, CURRENT_DATE()),
('Abastecimento Carro', 220.00, 'despesa', 6, CURRENT_DATE()),
('Cinema e Jantar', 150.00, 'despesa', 7, CURRENT_DATE());
