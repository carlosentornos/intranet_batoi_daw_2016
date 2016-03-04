-- BORRAR LOS DOS USUARIOS DE INTRANETBATOI
-- SELECCIONAR LA BASE DE DATOS
USE mysql;
-- BORRAR LOS USUARIOS EN localhost y cualquier red
DROP USER 'usuario_intranet'@'%';
DROP USER 'admin_intranet'@'localhost';
DROP USER 'admin_intranet'@'%';