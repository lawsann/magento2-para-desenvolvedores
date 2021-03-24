# Magento 2 para desenvolvedores

## Capítulo 01
### Projeto Docker

Este repositório contém o projeto Docker para criação do ambiente de desenvolvimento que será utilizado no decorrer do livro.

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

O projeto possui script's bash que funcionam como atalhos para algumas execuções de comandos nos container's. Estes script's estão localizados na pasta bin.

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


### Erros comuns

#### Pasta de instalação não vazia

No momento do download do Magento, pode aparecer o seguinte erro:

```
Project directory "/var/www/magento/." is not empty
```

Isto significa que a pasta onde será instalado o Magento não está vazia. Provavelmente, em uma tentativa de instalação anterior, ocorreu algum problema com o Composer no momento em que ele tentava baixar as dependências do Magento, encerrando o processo no meio do download. Isto faz com que alguns arquivos que já tenham sido baixados na pasta não sejam excluídos e ela não esteja mais vazia, gerando a mensagem de erro citada acima.

Para corrigir o problema, execute os comandos abaixo e depois tente realizar a ação de download novamente:

```
docker-compose exec phpapp /bin/rm -rf /var/www/magento/*
docker-compose exec phpapp /bin/rm -rf /var/www/magento/.*
```

Os comandos acima tentam remover o conteúdo da pasta /var/www/magento para solucionar o problema. Em alguns casos, usuários no sistema operacional Windows não obtiveram sucesso em realizar a remoção por meio das instruções acima. Temos ainda, como opção, os comandos abaixo:

```
docker container exec m2pd_phpapp_1 /bin/rm -rf /var/www/magento/*
docker container exec m2pd_phpapp_1 /bin/rm -rf /var/www/magento/.*
```
Caso não surta efeito e os arquivos permaneçam na pasta, busque conectar-se ao container Docker utilizando alguma ferramenta e remova os arquivos. Não se esqueça de remover também os arquivos escondidos (iniciados com o caractere '.' - ponto). Algumas IDE's possuem extensões para esta finalidade, como por exemplo, o VSCode, que possui a extensão 'Remote - Containers' para abrir uma pasta em um container Docker em execução como a pasta base do projeto - [https://code.visualstudio.com/docs/remote/containers-tutorial](https://code.visualstudio.com/docs/remote/containers-tutorial).
