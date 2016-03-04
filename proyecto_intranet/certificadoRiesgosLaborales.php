<!DOCTYPE html>
<?php
 
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['error']="No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
        header("Location:Login.php");
    }else{
        if($_SESSION['userType']!="direccion"){
            header("Location:controlPanel.php");
            $_SESSION['error']="No dispones de suficientes permisos para poder editar los datos de los alumnos.";
        }
    }
    
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Certificado riesgos laborales</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/certificadoRiesgos.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
    </head>
    <body>
 
        <?php
        include("cabecera.php");
        ?>
        <br>
        <div class="formularionormal borderedondo">
        <div class="contenedor">
        <form id="form" action="php/gestionDirModAlum.php" method="post" enctype="multipart/form-data">
 
            <br><h4 class="centrado"> CERTIFICADO DE RIESGOS LABORALES</h4><br>

            <br>
            <div class="nivel">
                <label for="horas"> HORAS DURACION CURSO *</label>
                <input id="horas" type="text" name="horas" required placeholder="Número de horas"/>
            </div>
            <div class="nivel">
                <label for="titulo"> NOMBRE DEL CURSO *</label>
                <input id="titulo" type="text" name="titulo" required placeholder="Título de Técnido Superior en ..."/>
            </div>
            <br><br>
            <div class="panel_manipulador">
                <label > SELECCION ALUMNO:</label>
                <input type="text" id="buscaralumno" name="buscaralumno"  autofocus/>
            </div>
            <div id="box">
                        <ul id="ulAlumnContainer">
 
                        </ul>
                    </div>
            </br><br><br>
            <div id="tableContainer" class="tabla">
            </div>
            </br></br>
            <div class="nivel panel_manipulador">
                <label for="grupo"> SELECCION GRUPO:</label>
                <select name="grupo" id="grupo">
                </select>
            </div>
            </br></br>
            <div id="tableContainer2" class="tabla">

            </div>
            <span id="submit"></span>
            <br><br>
        </form>
        </div>
        </div>



        <?php 
            include "pie.php";
         ?>
 
    </body>
</html>