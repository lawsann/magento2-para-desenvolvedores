create database magento2_db;
create user 'magento2_usr'@'localhost' identified by 'magento2_passwd';
grant all privileges on magento2_db.* to 'magento2_usr'@'localhost';