FROM ubuntu:20.04

# instalacao dos softwares de base
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y openssl curl vim wget apt-transport-https apt-utils gnupg2

# adicao do repositorio do elastic search
RUN wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | apt-key add -
RUN echo "deb https://artifacts.elastic.co/packages/7.x/apt stable main" | tee /etc/apt/sources.list.d/elastic-7.x.list

# instalacao dos softwares para rodar o Magento
RUN apt-get update && apt-get install -y nginx  \
        php7.4-cli php7.4-fpm php7.4-bcmath php7.4-ctype \
        php7.4-curl php7.4-xml php7.4-gd php7.4-common \ 
        php7.4-intl php7.4-mbstring php7.4-mysql php7.4-soap \ 
        php7.4-xsl php7.4-zip mariadb-server openjdk-11-jdk \
        elasticsearch

# instala composer
RUN apt-get install -y composer
#RUN composer global require hirak/prestissimo

# copa arquivo de criacao do banco de dados
COPY database/default-db-creation.sql /root/database/default-db-creation.sql

# copia arquivos de configuracao
COPY fpm/www.conf /etc/php/7.4/fpm/pool.d/www.conf
COPY nginx/magento241 /etc/nginx/sites-available/magento241
COPY nginx/default /etc/nginx/sites-available/default
COPY nginx/nginx.conf /etc/nginx/nginx.conf
RUN rm -rf /var/www/html

# cria usuario magento no so
RUN useradd -ms /bin/bash magento
RUN usermod -a -G www-data magento
RUN chown magento:www-data /var/www

# script de inicializacao dos servicos que roda a loja virtual
COPY m2pd-server-setup.sh /root/.
COPY magento-services-startup.sh /root/.
RUN chmod +x /root/m2pd-server-setup.sh
RUN chmod +x /root/magento-services-startup.sh

CMD ["/root/m2pd-server-setup.sh"]