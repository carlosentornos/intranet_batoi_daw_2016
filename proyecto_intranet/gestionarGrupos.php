<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Gestionar grupos </title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/gestionarGrupos.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
    </head>
    <body>
 
        <?php
        session_start();
        include("cabecera.php");
        ?>
 
        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor centrado">
                <br><h4 class="centrado">GESTIONAR GRUPOS</h4><br>

                <select class="noFlotar" id="grupo" >
 
                </select>

                <div id="tableContainer" class="calendario">
                    

                </div>

                <label for="buscaralumno"> Añadir alumno:</label>
                <input type="text" class="noFlotar" id="buscaralumno" name="buscaralumno"  autofocus  />

                <div id="box">
                
                    <ul id="ulAlumnContainer">
 
                    </ul>
                    
                </div>
               
            </div>
        </div>
 
        <?php
            include "pie.php";
        ?>
 
    </body>
</html>