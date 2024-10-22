# Projeto: Autenticação com Google

Este projeto foi desenvolvido para gerenciar a autenticação de usuários utilizando o Google OAuth, proporcionando uma solução simples e segura para login e registro de novos usuários via Google.

## Funcionalidades

A aplicação oferece as seguintes funcionalidades:

### Autenticação

**1ª Etapa:**
- Gera uma URL de autenticação do Google ou aceita um token de acesso de um usuário previamente autenticado.
- Realiza o pré-cadastro do usuário com as informações retornadas pelo Google (nome, email, token, e uma senha temporária).
- Redireciona para uma URL externa com o token obtido do Google.

**2ª Etapa:**
- Recebe os dados finais de cadastro do usuário (data de nascimento, CPF e nova senha).
- Redireciona para uma URL externa com os dados processados.

### Notificação por Email
- Após o término do cadastro, um email de boas-vindas é enviado ao usuário.

### Processamento de Jobs/Filas
- O sistema processa tarefas assíncronas utilizando filas, garantindo o envio de emails e outras tarefas de forma eficiente.

## Tecnologias Utilizadas

O projeto foi construído com a versão mais recente do **Laravel 11** e as seguintes tecnologias:

- **PHP 8.3**
- **Nginx**
- **Docker**
- **Redis**
- **Mailpit** (para captura de emails)

## Padrões de Projeto

Alguns padrões foram aplicados durante o desenvolvimento:

- **Service Layer:** Separa a lógica de negócios do restante da aplicação, melhorando a manutenibilidade.
- **Repository Pattern:** Abstrai o acesso aos dados, isolando o código de negócios da forma como os dados são armazenados e recuperados.



## Instalação

1 - Instale o docker e o docker compose no seu SO.

3 - Encerre todos os serviços rodando na sua máquina que usam as portas padrões do nginx/apache e mysql (80, 443, 3306).

4 - Rode os containers docker

```sh
docker compose up -d
```

5 - Instale as dependencias do projeto

```sh
docker compose exec app composer install
```

6 - Gere a chave de criptografia da aplicação
```sh
docker compose exec app php artisan key:generate 
```

7 - Rode as migratons e seeds
```sh
docker compose exec app php artisan migrate --seed
```

7 - Executar as filas (opcional)
```sh
docker compose exec app php artisan queue:work
```

## URLs da Aplicação

- Aplicação: [http://localhost:9000](http://localhost:9000)
- Mailpit (Servidor SMTP Local): [http://localhost:8025](http://localhost:8025)

## Observações

- O arquivo `.env-example` contém temporariamente as minhas chaves de autenticação do Google, facilitando o uso para testes. Elas serão removidas posteriormente.
- Para testar o envio de emails, não se esqueça de executar as filas com o comando mencionado no passo 7.
