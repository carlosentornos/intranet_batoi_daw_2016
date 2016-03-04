#!/bin/bash
# CREAR BASE DATOS + DATOS
# ----------------------------------------------
# Obtener fecha y hora
FECHAHORA=$(date +%Y%m%d_%H:%M:%S)
USUARIO="admin_intranet"
PASS="1234567890"
#-----------------------------------------------
# crear el backup de la base de datos
# ESTRUCTURA DE LA BASE DE DATOS Y SUS DATOS
mysqldump -u $USUARIO -p$PASS --databases IntranetBatoi > $FECHAHORA"_IntranetBatoi_DB_DATA.bak"
#mysqldump -u $USUARIO -p$PASS --databases IntranetBatoi > $FECHAHORA"backup_IntranetBatoi_DB_DATA.sql"

# SOLO ESTRUCTURA DE LA BASE DE DATOS
mysqldump -d -u $USUARIO -p$PASS -d IntranetBatoi > $FECHAHORA"_IntranetBatoi_DB.bak"
#mysqldump -d -u $USUARIO -p$PASS -d IntranetBatoi > $FECHAHORA"_IntranetBatoi_DB.sql"

# SOLO LOS DATOS
mysqldump -t -u $USUARIO -p$PASS -t IntranetBatoi > $FECHAHORA"_IntranetBatoi_DATA.bak"
#mysqldump -t -u $USUARIO -p$PASS -t IntranetBatoi > $FECHAHORA"_IntranetBatoi_DATA.sql"
#
# FIN DEL FICHERO
