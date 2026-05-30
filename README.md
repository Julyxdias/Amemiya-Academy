<p align="center">
  <img src="public/designer.png" alt="Amemiya Academy Logo" width="120" />
</p>

<h1 align="center">Amemiya Academy</h1>

<p align="center">
  Plataforma de treinamento corporativo para gestão e acompanhamento de cursos internos.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-blue?style=flat-square&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white" />
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/status-academic-lightgrey?style=flat-square" />
</p>

---

## 📖 Sobre o projeto

**Amemiya Academy** é uma plataforma web desenvolvida para centralizar e gerenciar o treinamento de colaboradores de uma organização. O sistema permite que administradores cadastrem cursos e que os colaboradores acompanhem seu progresso de forma simples e intuitiva.

Projeto desenvolvido como trabalho acadêmico na disciplina de Engenharia da Computação.

---

## ✨ Funcionalidades

### 👤 Colaborador
- Login por registro funcional + senha
- Visualização de todos os cursos disponíveis
- Acesso direto ao conteúdo via link externo
- Acompanhamento de progresso individual (não iniciado / em andamento / concluído)
- Filtro e busca por nome ou categoria

### 🔧 Administrador
- Painel exclusivo de gerenciamento
- Cadastro, edição e exclusão de cursos
- Definição de título, descrição, categoria, capa e link de acesso
- Busca e filtragem em tempo real na lista de cursos

---

## 🛠️ Stack

| Camada | Tecnologia |
|---|---|
| Frontend | HTML5, CSS3, JavaScript (Vanilla) |
| Backend | PHP 8.x |
| Banco de dados | MySQL |
| Servidor local | Apache (XAMPP / WAMP) |

---

## 🗂️ Estrutura do projeto

```
amemiya_academy/
├── api/
│   ├── db.php                  # Conexão com o banco
│   ├── login.php               # Autenticação de usuário
│   ├── get_courses.php         # Listagem de cursos (admin)
│   ├── get_user_courses.php    # Cursos com progresso do usuário
│   ├── admin_add_course.php    # Criar curso
│   ├── admin_update_course.php # Editar curso
│   ├── admin_delete_course.php # Excluir curso
│   └── update_progress.php     # Atualizar progresso do usuário
├── public/
│   ├── login.html              # Tela de login
│   ├── dashboard_admin.html    # Painel do administrador
│   ├── dashboard_usuario.html  # Painel do colaborador
│   ├── styles.css              # Estilos globais
│   └── designer.png            # Logo do sistema
└── amemiya_academy.sql         # Script de criação do banco
```

---

## 🚀 Como rodar localmente

### Pré-requisitos
- XAMPP, WAMP ou qualquer servidor com Apache + PHP + MySQL

### Passos

```bash
# 1. Clone o repositório
git clone https://github.com/Julyxdias/Amemiya-Academy.git

# 2. Mova para a pasta do servidor
# XAMPP: mova para C:/xampp/htdocs/amemiya_academy
# Linux: mova para /var/www/html/amemiya_academy

# 3. Importe o banco de dados
# Acesse o phpMyAdmin e importe o arquivo amemiya_academy.sql

# 4. Acesse no navegador
http://localhost/amemiya_academy/public/login.html
```

### Configuração do banco

Edite o arquivo `api/db.php` com suas credenciais:

```php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "sua_senha";
$DB_NAME = "amemiya_academy";
```

---

## 🔐 Autenticação

O sistema distingue automaticamente dois perfis via campo `role` na tabela `users`:

| Perfil | Acesso |
|---|---|
| `admin` | Painel de gerenciamento de cursos |
| `user` | Dashboard de cursos e progresso |

As senhas são armazenadas com `password_hash()` do PHP (bcrypt).

---

## 📸 Screenshots

> _Login, dashboard do colaborador e painel administrativo._

| Login | Dashboard Colaborador | Painel Admin |
|---|---|---|
| _(adicione print aqui)_ | _(adicione print aqui)_ | _(adicione print aqui)_ |

---

## 👩‍💻 Autora

Desenvolvido por **[Julyxdias](https://github.com/Julyxdias)** e **[Karolaine]([https://github.com/Julyxdias](https://github.com/Karolaine231))** — Engenharia da Computação.

---

<p align="center">
  <sub>Projeto acadêmico • 2025</sub>
</p>
