## Sobre o Projeto

Para desenvolvimento do projeto foi utilizado o Framework Laravel na versão 11, utilizando docker para execução do projeto.
Também foi utilizando banco de dados mysql para gravar/manipular os registros.

## Rodando o Projeto

Para executar o projeto será necessário:

1. Iniciar o PHP e o Banco de Dados(As configs estão no arquivo .env)
```bash
docker-compose up
```
2. Acessar o container da aplicacao(ebanx-app)
```bash
docker ps
docker exec -it CONTAINER_ID bash
```
2. Gerar a tabela no schema
```bash
php artisan migrate
```
