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

Digite o seguinte comando para baixar e construir as imagens dos container's na sua máquina hospedeira:

```
docker-compose build
```

### Criação dos container's (up)

Digite o seguinte comando para criar e iniciar os container em background:

```
docker-compose up -d
```

### Download Magento

O projeto possui script's bash que funcionam como atalhos para algumas execuções de comandos nos container's. Estes script's localizam-se na pasta bin.

Um dos primeiros comandos úteis a serem utilizados realiza o download do Magento na versão 2.4.2. Para executar este comando, a partir da pasta base do repositório, digite o seguinte comando:


```
bin/download
```

As credenciais no Magento Marketplace serão solicitadas. Caso ainda não as tenha, faça seu cadastro em [https://marketplace.magento.com/](https://marketplace.magento.com/).

### Instalação Magento

Para realizar a instalação do Magento com os dados básicos pré-definidos, execute o seguinte comando em seu terminal:

```
bin/install
```

### Usuários Windows

Para usuários do sistema operacional Windows que não consigam executar script's em seus terminais, deixamos as referências dos comandos completos na pasta `bin/windows`. Copie o comando contido no arquivo relativo à ação desejada, cole no terminal e execute-o.
