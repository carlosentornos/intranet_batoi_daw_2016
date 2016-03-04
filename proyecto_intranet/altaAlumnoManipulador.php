<!DOCTYPE html>
<?php  
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
    header("Location:Login.php");
} else {
    if ($_SESSION['userType'] != "alumno") {
        header("Location:controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los alumnos.";
    }
}
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Manipulador de alimentos</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/altaAlumnoManipulador.js"></script>
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
                <?php
                include_once "php/datosServidor.php";
                echo "<h4 class='centrado'>REGISTRO CURSO MANIPULADOR DE ALIMENTOS</h4><br>";
                
                if (alumnoTieneCurso()) {
                    $registrado = checkRegistradoAlumnosManipulador(getCursoActivoAlumno());
                    if ($registrado === "n") {
                        echo "<p class='rojo'>Estas en lista de espera.</p>";
                    } else {
                        echo "<p class='verde'>Actualmente estas activo para realizar el curso de manipulador de alimentos.</p>";
                    }
                    echo "<button class='boton' type='button'>Darse de baja</button>";
                } else {
                    $cursos = getCursosActivos();
                    echo "<br><div>";
                    echo "Seleccione el curso de manipulador de alimentos:";

                    echo "<select id='cursosManipulador'>";
                    echo "<option value='selecciona' selected> - Selecciona - </option>";
                    foreach ($cursos as $item) {
                        echo "<option value='" . $item['codigo'] . "'>" . $item['codigo'] . " - " . $item['horario'] . "</option>";
                    }
                    echo "</select></div>";
                    echo "<button class='boton' type='button'>Registrarse</button>";
                }
                ?> 
            </div>
        </div>

        <?php
        include "pie.php";
        ?>

    </body>
</html>
