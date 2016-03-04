<?php
        /**
         * Este archivo se utilizará para desconectar al usuario de la sesion.
         */
	session_start();
	require_once("Classes/Class_Auth.php");
	
	$log=new Auth();
	$log->Disconnect();
	header("Location:../login.php");

?>
