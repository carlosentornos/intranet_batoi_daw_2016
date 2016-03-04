#!/bin/bash
# CREAR BASE DATOS + DATOS REMOTAMENTE
clear
echo "***********************************************"
echo "*   CARGA REMOTA INTRANET BATOI BD y DATOS    *"
echo "***********************************************"
echo " "
echo "Introduzca el usuario con permisos suficientes para acceder a MYSQL"
read USUARIO
echo " "
echo "Introduca el password del usuario [ $USUARIO ]"
read PASS
echo " "
echo "Introduca la IP del servidor"
read IPSERVER
echo " "

# crear la base de datos
mysql -u $USUARIO -p$PASS -h $IPSERVER < IntranetBatoi.sql

# carga de datos a partir archivos SQL
# DEPARTAMENTOS
echo "Tabla departamentos con datos OK. "
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_departamentos.sql
# PROFESOR
echo "Tabla profesores con datos OK. "
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_profesor.sql
# PROFESORES
#echo "Tabla profesores con datos"
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_profesores.sql
# GRUPOS
echo "Tabla grupos con datos OK."
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_grupos.sql
# ALUMNOS
echo "Tabla alumnos con datos OK. "
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_alumnos.sql
# PROVINCIAS
echo "Tabla provincias con datos OK. "
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_provincias.sql
# MUNICIPIOS
echo "Tabla municipios con datos OK. "
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_municipios.sql
# CARGA MAS ALUMNOS
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_alumnos_a.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_alumnos_b.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_alumnos_c.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < datos_alumnos_d.sql
echo " ...120 alumnos insertados OK. "
# CARGA MANIPULADOR ALIMENTOS
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < manipulador_alimentos.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_manipulador_alimentos.sql
echo " Tabla manipulador alimentos y datos con alumnos OK. "
# CARGA DE ALUMNOS CON GRUPOS
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_grupos.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_grupos_a.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_grupos_b.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_grupos_c.sql
mysql -u $USUARIO -p$PASS -h $IPSERVER IntranetBatoi < alumnos_has_grupos_d.sql
echo " ...carga de alumnos en grupos OK. "
echo " "
echo "***********************************************"
echo "           Carga local finalizada              "
echo "***********************************************"