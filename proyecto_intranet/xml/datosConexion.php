<?php

$ip = '192.168.214.83';
$user = 'chvdaw';
$pass = '123456789';
$db = 'IntranetBatoi2';
$connection = new DB($ip, $user, $pass, $db);
$connection->Connect();
//conexion realizada, funcion GetConn para usar la conexion
$conn = $connection->GetConn();