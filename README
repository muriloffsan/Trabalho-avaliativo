# TaskSync

TaskSync é um gerenciador de tarefas simples, desenvolvido em PHP e MySQL, com interface web responsiva. O sistema permite cadastrar usuários, criar tarefas, editar, excluir e alterar o status das tarefas em um quadro Kanban.

## Funcionalidades

- Cadastro de usuários
- Cadastro de tarefas com responsável, descrição, setor e prioridade
- Edição e exclusão de tarefas
- Alteração de status das tarefas (A Fazer, Fazendo, Concluído)
- Interface responsiva e intuitiva

## Estrutura do Projeto

```
add_task_page.php        # Página para adicionar nova tarefa
add_task.php             # Lógica para inserir tarefa no banco
add_user_page.php        # Página para adicionar novo usuário
add_user.php             # Lógica para inserir usuário no banco
change_status.php        # Altera o status de uma tarefa
config.php               # Configuração de conexão com o banco de dados
delete_task.php          # Exclui uma tarefa
edit_task.php            # Edita uma tarefa existente
index.php                # Página principal com o quadro de tarefas
style.css                # Estilos da aplicação
tasksync_db.sql          # Script SQL do banco de dados com dados de exemplo
```

## Pré-requisitos

- PHP 7.x ou superior
- MySQL/MariaDB
- Servidor web (Apache recomendado)
- Extensão mysqli habilitada no PHP

## Instalação

1. **Clone ou copie os arquivos para o diretório do seu servidor web.**

2. **Importe o banco de dados:**

   - No phpMyAdmin ou via terminal, importe o arquivo `tasksync_db.sql` para criar as tabelas e inserir dados de exemplo:

   ```
   mysql -u seu_usuario -p tasksync_db < tasksync_db.sql
   ```

3. **Configure o acesso ao banco de dados em [`config.php`](config.php):**

   Verifique se os dados de acesso (`DB_SERVER`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`) estão corretos para o seu ambiente.

4. **Acesse o sistema pelo navegador:**

   ```
   http://localhost/Trabalho%20avaliativo/index.php
   ```

## Observações

- O sistema não possui autenticação de usuários.
- Recomenda-se utilizar em ambiente local ou restrito.
- Para customizar estilos, edite o arquivo [`style.css`](style.css).

## Licença

Este projeto é apenas para fins acadêmicos e de aprendizado.

---

Desenvolvido por [Seu Nome]