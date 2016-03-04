#!/bin/bash
# cargar datos directamente en el propio servidor
clear
echo "***********************************************"
echo "*    CARGA LOCAL INTRANET BATOI BD y DATOS    *"
echo "***********************************************"
echo " "
echo "Introduzca el usuario con permisos suficientes para acceder a MYSQL"
read USUARIO
echo "Introduca el password del usuario [ $USUARIO ]"
read PASS
echo " "
# crear la base de datos
mysql -u $USUARIO -p$PASS < IntranetBatoi.sql

# carga de datos a partir archivos SQL
# DEPARTAMENTOS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_departamentos.sql
echo " Tabla departamentos con datos OK. "
# PROFESOR
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_profesor.sql
echo " Tabla profesores con datos OK. "
# PROFESORES
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_profesores.sql
#echo " Tabla profesores con datos "
# GRUPOS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_grupos.sql
echo " Tabla grupos con datos OK. "
# ALUMNOS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_alumnos.sql
echo " Tabla alumnos con datos OK. "
# PROVINCIAS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_provincias.sql
echo " Tabla provincias con datos OK. "
# MUNICIPIOS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_municipios.sql
echo " Tabla municipios con datos OK. "
# CARGA MAS ALUMNOS
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_alumnos_a.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_alumnos_b.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_alumnos_c.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < datos_alumnos_d.sql
echo " ...120 alumnos insertados OK. "
# CARGA MANIPULADOR ALIMENTOS
mysql -u $USUARIO -p$PASS IntranetBatoi < manipulador_alimentos.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_manipulador_alimentos.sql
echo " Tabla manipulador alimentos y datos con alumnos OK. "
# CARGA DE ALUMNOS CON GRUPOS
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_grupos.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_grupos_a.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_grupos_b.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_grupos_c.sql
mysql -u $USUARIO -p$PASS IntranetBatoi < alumnos_has_grupos_d.sql
echo " ...carga de alumnos en grupos OK. "
echo " "
echo "***********************************************"
echo "           Carga local finalizada              "
echo "***********************************************"
