# 🚀 Tutorial de Execução: Projeto MVC PHP 8.5 no Windows com Docker Desktop

Este guia foi elaborado para orientar os alunos sobre como instalar, executar e testar o projeto de **Controle Financeiro em PHP 8.5 MVC** em computadores com sistema operacional **Windows**, utilizando o **Docker Desktop**.

---

## 💻 1. Pré-requisitos Recomendados

Antes de iniciar, certifique-se de ter instalado no seu computador:

1. **Docker Desktop para Windows**  
   - Download oficial: [docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
   - *Nota*: Durante a instalação do Docker Desktop, mantenha marcada a opção **"Use WSL 2 instead of Hyper-V"** (recomendado para maior desempenho).
2. **VS Code (Visual Studio Code)**  
   - Download oficial: [code.visualstudio.com](https://code.visualstudio.com/)
3. **Git para Windows** (opcional, mas recomendado)  
   - Download oficial: [gitforwindows.org](https://gitforwindows.org/)

---

## 🛠️ 2. Passo a Passo para Iniciar o Projeto

### Passo 1: Abrir o Docker Desktop
- Abra o menu Iniciar do Windows, procure por **Docker Desktop** e clique para iniciar.
- Aguarde até que o ícone do Docker na barra de tarefas (próximo ao relógio) fique com o status **"Docker Desktop is running"** (ícone da baleia azul estático).

---

### Passo 2: Abrir a Pasta do Projeto no VS Code
1. Abra o **VS Code**.
2. Vá em **Arquivo (File) > Abrir Pasta (Open Folder)**.
3. Selecione a pasta do projeto `aulaphpmvc_ctrlfin`.

---

### Passo 3: Abrir o Terminal Integrado no VS Code
- No VS Code, pressione o atalho `Ctrl + '` (ou acesse o menu superior **Terminal > Novo Terminal**).
- O terminal abrirá na parte inferior (pode ser o **PowerShell**, **Command Prompt** ou **Git Bash**).

---

### Passo 4: Subir os Contêineres com Docker Compose
No terminal do VS Code, digite o seguinte comando e pressione `Enter`:

```bash
docker compose up -d
```

#### 📌 O que este comando faz?
- Baixa as imagens oficiais do **Nginx**, **PHP 8.5** e **MariaDB 11.4**.
- Compila a imagem do **PHP 8.5** com suporte às extensões de banco de dados (`pdo_mysql`).
- Cria as tabelas e insere os dados iniciais de exemplo automaticamente no MariaDB.
- Inicia os três contêineres da aula: `aula_nginx`, `aula_php8.5` e `aula_mariadb`.

---

### Passo 5: Acessar a Aplicação no Navegador
Abra o seu navegador de preferência (Chrome, Edge, Firefox) e acesse o endereço:

👉 **[http://localhost:8080](http://localhost:8080)**

Você verá a tela do **Dashboard de Controle Financeiro** pronta e totalmente funcional! 🎉

---

## 🛠️ 3. Comandos Úteis Durante as Aulas

Todos os comandos devem ser executados no terminal na pasta do projeto:

### 1. Verificar se os contêineres estão rodando
```bash
docker compose ps
```
Você verá os contêineres `aula_nginx`, `aula_php8.5` e `aula_mariadb` com o status `Up` ou `healthy`.

### 2. Acompanhar os logs do PHP em tempo real
Caso queira visualizar mensagens de erro ou logs de execução do PHP:
```bash
docker compose logs -f aula_php8.5
```
*(Para sair dos logs, pressione `Ctrl + C`)*.

### 3. Atualizar o Autoloader após criar novas classes
Se você criar uma nova classe dentro da pasta `src/` ou `core/`:
```bash
docker compose exec aula_php8.5 composer dump-autoload
```

### 4. Parar a aplicação ao final da aula
```bash
docker compose down
```

### 5. Reiniciar o Banco de Dados do Zero (Limpar dados)
Se quiser apagar todos os registros criados e recarregar os dados iniciais do `seed.sql`:
```bash
docker compose down -v
docker compose up -d
```

---

## ❓ 4. Resolução de Problemas Comuns (Troubleshooting)

### 🔴 Problema A: "Cannot connect to the Docker daemon"
- **Causa**: O aplicativo Docker Desktop não foi iniciado no Windows.
- **Solução**: Procure por **Docker Desktop** no menu Iniciar, abra o aplicativo e aguarde o ícone da baleia estabilizar antes de rodar o comando no terminal.

---

### 🔴 Problema B: "Port 8080 is already in use" ou "Port 3306 is already in use"
- **Causa**: Outro programa no seu computador (como XAMPP, Laragon, MySQL local ou IIS) já está utilizando a porta `8080` ou `3306`.
- **Solução**:
  1. Abra o arquivo `docker-compose.yml` no VS Code.
  2. Altere a porta do Nginx de `"8080:80"` para `"8081:80"` ou `"9000:80"`.
  3. Salve o arquivo e rode `docker compose up -d` novamente.
  4. Acesse pelo novo endereço (ex: `http://localhost:8081`).

---

### 🔴 Problema C: Alterações no código PHP não aparecem no navegador
- **Causa**: O navegador pode ter guardado o cache da página.
- **Solução**: Pressione `Ctrl + F5` no navegador para forçar a atualização sem cache.

---

## 📂 5. Visão Geral da Estrutura para os Alunos

```text
aulaphpmvc_ctrlfin/
├── core/         # Onde fica o nosso micro-framework (Router, Controller base, PDO Database)
├── src/          # Onde vocês escreverão as regras da aula (Models, Controllers, Repositories)
├── views/        # Onde ficam os arquivos HTML/PHP de interface visual
├── public/       # Onde ficam os arquivos estáticos (CSS, imagens) e o index.php principal
└── docker-compose.yml # Arquivo de configuração dos servidores Docker
```

Bons estudos e excelente aula de MVC em PHP 8.5! 🚀
