# 🐧 Guia de Execução no Fedora Linux (Para o Professor)

Este guia apresenta os passos e boas práticas para executar e administrar o projeto de **Controle Financeiro MVC em PHP 8.5** em uma distribuição **Fedora Linux**.

---

## 🛠️ 1. Instalação e Configuração no Fedora

No Fedora, você pode utilizar tanto o **Docker Engine oficial** quanto o **Podman** (ferramenta nativa do ecossistema Red Hat/Fedora).

### Opção A: Utilizando Docker Engine Oficial no Fedora (Recomendado)

1. **Instalar os pacotes oficiais do Docker e Docker Compose**:
   ```bash
   sudo dnf config-manager --add-repo https://download.docker.com/linux/fedora/docker-ce.repo
   sudo dnf install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
   ```

2. **Iniciar e habilitar o serviço do Docker**:
   ```bash
   sudo systemctl enable --now docker
   ```

3. **Adicionar seu usuário ao grupo `docker`** (evita a necessidade de usar `sudo` em todos os comandos):
   ```bash
   sudo usermod -aG docker $USER
   newgrp docker
   ```

---

### Opção B: Utilizando Podman & Podman Compose (Nativo do Fedora)

Se preferir utilizar a ferramenta nativa do Fedora sem daemon:

1. **Instalar Podman e Podman Compose**:
   ```bash
   sudo dnf install podman podman-compose
   ```

2. **Subir os contêineres**:
   ```bash
   podman-compose up -d
   ```

---

## 🚀 2. Comandos de Execução no Fedora

Na pasta do projeto `aulaphpmvc_ctrlfin`:

```bash
# Subir os 3 contêineres (aula_nginx, aula_php8.5, aula_mariadb)
docker compose up -d

# Verificar o status e saúde dos contêineres
docker compose ps

# Acompanhar os logs do PHP 8.5
docker compose logs -f aula_php8.5

# Testar a resposta da aplicação via terminal
curl -i http://localhost:8080

# Parar a aplicação
docker compose down
```

---

## 🔒 3. Considerações de Segurança no Fedora (SELinux e Firewall)

### A. SELinux (Security-Enhanced Linux)
O Fedora utiliza o **SELinux** ativado por padrão em modo `Enforcing`. 

Se você notar erros de permissão de leitura nos volumes montados do host para os contêineres:
- O Docker gerencia os mapeamentos do volume `./` automaticamente.
- Se necessário rotular os volumes no Docker Compose para SELinux, pode-se adicionar o sufixo `:z` nos volumes compartilhados (ex: `./:/var/www/html:z`).

### B. Firewall (`firewalld`)
O Fedora utiliza o `firewalld`. Como o Nginx está mapeado na porta `8080`, ele estará acessível em `localhost:8080`. Se você quiser que os alunos na mesma rede local acessem a sua máquina Fedora para demonstração:

```bash
sudo firewall-cmd --add-port=8080/tcp --permanent
sudo firewall-cmd --reload
```

---

## 📚 4. Organização do Material da Aula

No diretório do projeto, você agora possui a documentação completa para ambos os perfis:

- 📄 **`TUTORIAL_EXECUCAO_WINDOWS.md`**: Guia passo a passo para os **alunos** (Windows + Docker Desktop).
- 📄 **`TUTORIAL_EXECUCAO_FEDORA.md`**: Guia para você, **professor** (Fedora Linux).
- 📄 **`PHP_8.5_MVC_Teaching_Plan.md`**: Plano pedagógico detalhado da aula.

Bom curso e excelente aula! 🚀
