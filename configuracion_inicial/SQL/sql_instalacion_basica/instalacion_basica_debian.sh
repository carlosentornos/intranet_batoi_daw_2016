#!/bin/bash
# cargar datos directamente en el propio servidor
clear
echo "***********************************************"
echo "*   INSTALACION DE PAQUETES SERVIDOR DEBIAN   *"
echo "***********************************************"
echo " "
# actualizar repositorios
apt-get update
# comprobar dependencias
aptitude update
# INSTALAR APACHE 2
apt-get install apache2 apache2-utils apache2-doc libapache2-mod-auth-mysql
echo "***********************************************"
echo "Apache Instalado"
echo "***********************************************"
# INSTALAR MYSQL
apt-get install mysql-server php5-mysql
echo "***********************************************"
echo "MySQL Instalado"
echo "***********************************************"
# INSTALAR PHP
apt-get install php5 php5-mcrypt php5-curl mcrypt
echo "***********************************************"
echo "PHP Instalado"
echo "***********************************************"
# INSTALAR phpMyAdmin
apt-get install phpmyadmin
echo "***********************************************"
echo "PHPMYADMIN Instalado"
echo "***********************************************"
# INSTALAR OPENSSH SERVER
apt-get install openssh-server
echo "***********************************************"
echo "OpenSSH-Server Instalado"
echo "***********************************************"
# INSTALAR SERVIDOR FTP
apt-get install vsftpd
echo "***********************************************"
echo "SERVIDOR FTP - vsftpd Instalado"
echo "***********************************************"
# INSTALAR COMPRESORES
apt-get install p7zip-full unzip zip
echo "***********************************************"
echo "Compresores p7zip-full unzip zip Instalados"
echo "***********************************************"
# PAQUETES NECESARIOS PARA INSTALAR WEBMIN
apt-get install libauthen-pam-perl libio-pty-perl apt-show-versions libapt-pkg-perl libnet-ssleay-perl
apt-get install iptraf htop
echo " "
echo "***********************************************"
echo "           Instalación finalizada              "
echo "***********************************************"
