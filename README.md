# Magento 2 para desenvolvedores

## Capípulo 01
### Projeto Docker

Este repositório contém o projeto Docker para criação da do ambiente de desenvolvimento que será utilizado no decorrer do livro.

O projeto cria quatro serviços para executar o software Magento, utilizando o Docker Compose:

* httpserver: possui o Nginx configurado para ser nosso servidor HTTP;
* phpapp: container que rodará a aplicação do Magento, por meio do PHP-FPM;
* db: instância do MariaDB, representando o papel do nosso banco de dados;
* search: container com o ElasticSearch instalado e configurado.

### Construção das imagens (build)

Digite o seguinte comando para baixar e construir as imagens dos containers na sua máquina hospedeira:

```
docker-compose build
```

### Criação dos container's (up)

Digite o seguinte comando para criar e iniciar os container em background:

```
docker-compose up -d
```

