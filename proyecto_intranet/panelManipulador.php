
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Manipulador de alimentos</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/panelManipulador.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
    </head>
    <body>

        <?php
        session_start();
        include("cabecera.php");
        ?>

        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <br>
                <h4 class="centrado" >MANIPULADOR DE ALIMENTOS</h4><br>
                <div id="contenedorbotones" class="centrado">
                    <a href="darDeAltaManipulador.php"><button class="button">ALTA CURSO</button></a>
                    <button id="marcarComo" class="button">MARCAR COMO</button>
                    <button id="hojaFirmas" class="button">HOJA DE FIRMAS</button>
                </div>

                <form class="panel_manipulador">
                    <label for="filtro">FILTRO</label>
                    <select id="filtro" name="filtro">
                        <option>Seleccionar</option>
                    </select>

                    <input type="text" id="buscaralumno" name="buscaralumno"/>
                    <div id="box">
                        <ul id="ulAlumnContainer">

                        </ul>
                    </div>
                    <br><br>

                    
                    <input id="submit" class="boton " type="submit" value="GENERAR PDF">

                </form>
            </div>
            <div id="tableContainer" class="tabla">

            </div>
        </div>

        <?php
        include "pie.php";
        ?>

    </body>
</html>
