# FoodStock - Controle de Estoque

Sistema web simples de CRUD (Criar, Ler, Atualizar, Excluir) para controle de
estoque de insumos alimentícios, desenvolvido em PHP e MySQL.

## Estrutura do Projeto

```
foodstock/
├── config/
│   └── db.php              -> Conexão com o banco de dados (PDO)
├── views/
│   ├── header.php          -> Cabeçalho HTML (Bootstrap)
│   └── footer.php          -> Rodapé HTML
├── actions/
│   ├── cadastrar_action.php -> Lógica de inserção (Create)
│   ├── editar_action.php    -> Lógica de atualização (Update)
│   └── excluir.php          -> Lógica de exclusão (Delete)
├── assets/
│   └── style.css             -> Estilos próprios (por cima do Bootstrap)
├── uploads/                    -> Fotos dos produtos enviadas pelo formulário
├── index.php                -> Listagem principal (Read)
├── cadastrar.php             -> Formulário de cadastro
├── editar.php                -> Formulário de edição
├── visualizar.php             -> Detalhes de um produto
└── banco.sql                  -> Script de criação do banco de dados
```

## Como configurar localmente

1. **Instale um servidor local** com PHP e MySQL, como o
   [XAMPP](https://www.apachefriends.org/) ou WampServer.

2. **Copie a pasta do projeto** (`foodstock/`) para dentro da pasta
   `htdocs` (XAMPP) ou `www` (WampServer).

3. **Crie o banco de dados:**
   - Abra o phpMyAdmin (geralmente em `http://localhost/phpmyadmin`).
   - Vá em "Importar" e selecione o arquivo `banco.sql`, ou execute
     seu conteúdo na aba SQL.
   - Isso vai criar o banco `db_foodstock` e a tabela `produtos`.

4. **Confira os dados de acesso ao banco** no arquivo `config/db.php`.
   Por padrão, usa usuário `root` e senha em branco (padrão do XAMPP).
   Ajuste se o seu ambiente for diferente.

5. **Confira se a pasta `uploads/` tem permissão de escrita**, pois é
   nela que as fotos dos produtos são salvas.

6. **Acesse o sistema no navegador:**
   ```
   http://localhost/foodstock/index.php
   ```

## Funcionalidades

- **Criar:** cadastro de novos produtos com validação (quantidade deve ser
  maior que zero) e envio opcional de foto do produto (JPG, PNG ou WEBP).
- **Ler:** listagem de todos os produtos na página inicial, com opção de
  ver detalhes de um produto específico.
- **Atualizar:** edição dos dados de um produto já cadastrado.
- **Excluir:** remoção de um produto, com confirmação via JavaScript.
- **Mensagens de feedback** exibidas com `$_SESSION` após cada ação.
- **Proteção contra XSS** usando `htmlspecialchars()` em todos os dados
  exibidos na tela.
- **Consultas seguras** ao banco de dados usando *prepared statements*
  (PDO), evitando SQL Injection.
- Interface responsiva com **Bootstrap 5** (via CDN).
