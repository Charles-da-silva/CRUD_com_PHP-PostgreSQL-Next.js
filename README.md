# CRUD de Clientes — PHP + PostgreSQL + Next.js

Projeto simples de CRUD (Create, Read, Update, Delete) desenvolvido para consolidar fundamentos de backend com PHP e integração com frontend moderno.

## 🧱 Stack utilizada

* **Frontend:** Next.js (React + TypeScript)
* **Backend:** PHP (API REST simples)
* **Banco de dados:** PostgreSQL (rodando via Docker)
* **Cliente HTTP para testes:** Thunder Client

---

## ⚙️ Funcionalidades

* Criar cliente
* Listar clientes
* Atualizar cliente
* Deletar cliente
* Feedback visual de sucesso/erro nas operações

---

## 📁 Estrutura do projeto

```
/backend
  ├── index.php
  ├── db.php

/frontend
  ├── app/
  │   └── page.tsx
  ├── package.json
```

---

## 🚀 Como executar o projeto

### 1. Subir o banco de dados (Docker)

```bash
docker run --name postgres-crud \
  -e POSTGRES_PASSWORD=1234 \
  -e POSTGRES_DB=crud_php_db \
  -p 5433:5432 \
  -d postgres
```

---

### 2. Criar tabela

Acesse o container e execute:

```sql
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 3. Rodar backend (PHP)

Dentro da pasta `/backend`:

```bash
php -S localhost:8000
```

A API ficará disponível em:

```
http://localhost:8000/index.php
```

---

### 4. Rodar frontend (Next.js)

Dentro da pasta `/frontend`:

```bash
npm install
npm run dev
```

Acesse:

```
http://localhost:3000
```

---

## 🔌 Endpoints da API

| Método | Endpoint     | Descrição        |
| ------ | ------------ | ---------------- |
| GET    | `/index.php` | Lista clientes   |
| POST   | `/index.php` | Cria cliente     |
| PUT    | `/index.php` | Atualiza cliente |
| DELETE | `/index.php` | Remove cliente   |

### 📥 Exemplo de payload (POST)

```json
{
  "nome": "João",
  "email": "joao@email.com"
}
```

### 📥 Exemplo (PUT)

```json
{
  "id": 1,
  "nome": "João Alberto",
  "email": "joao@email.com"
}
```

---

## 🔁 Fluxo da aplicação

1. Frontend envia requisição via `fetch`
2. PHP recebe via `php://input`
3. Query executada no PostgreSQL via PDO
4. API retorna JSON com `success` e `message`
5. Frontend atualiza UI e exibe feedback

---

## ⚠️ Pontos técnicos importantes

* Uso de **PDO** para conexão segura com o banco
* Tratamento de requisições HTTP (GET, POST, PUT, DELETE)
* Controle de estado no React com `useState` e `useEffect`
* Inputs controlados e validação básica
* Tratamento de erros e feedback visual
* Configuração de **CORS** no backend

---

## 🧪 Testes

Os endpoints foram testados utilizando Thunder Client (VS Code).

---

## 📌 Melhorias futuras

* Validação mais robusta de inputs (backend e frontend)
* Paginação na listagem
* Separação em camadas no backend (Controller / Service / Repository)
* Uso de variáveis de ambiente (.env)
* Dockerização completa (frontend + backend)
* Autenticação básica

---


