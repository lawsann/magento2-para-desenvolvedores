#!/bin/bash
service nginx start
service php7.4-fpm start
service mysql start
service elasticsearch start
mysql -u root < /root/database/default-db-creation.sql
/bin/bash