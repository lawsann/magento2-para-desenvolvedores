FROM nginx:1.18-alpine
LABEL maintainer="Fillipe Almeida Dutra <fillipe@querycommerce.com>" \
      Description="Servidor HTTP sugerido para o livro Magento 2 para desenvolvedores." \
      Version="1.0.0"

RUN addgroup -g 1000 magento \
    && adduser -G magento -u 1000 -h /home/magento -s /bin/bash -S magento
RUN touch /var/run/nginx.pid
RUN mkdir /sock
RUN mkdir /var/www
RUN mkdir /var/www/magento
RUN mkdir /etc/nginx/custom.d

COPY ./conf/nginx.conf /etc/nginx/
COPY ./conf/default.conf /etc/nginx/conf.d/
COPY ./conf/magento-2.4.2.conf /etc/nginx/custom.d/

RUN chown -R magento:magento /etc/nginx /var/www/magento /var/cache/nginx /var/run/nginx.pid /sock

USER magento:magento
VOLUME /var/www/magento
WORKDIR /var/www/magento/

EXPOSE 80