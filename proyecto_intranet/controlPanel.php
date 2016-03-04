<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder al panel de control si no estas previamente identificado.";
    header("Location:Login.php");
}
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Panel de control</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediaprincipal.css">
    </head>
    <body>

        <?php
        include("cabecera.php");
        ?>
        <br>

        <div class="formularionormal borderedondo ajustaralto">
            <br><br><h1 class="centrado" >PANEL DE CONTROL</h1><br><br>
            <div class="contenedorEnlaces centrado">
                <?php
                echo '<a class="enlace borderedondo" target="_blank" href="https://itaca.edu.gva.es/"><img alt="imagen ittaca" src="imagenes/itaca.png"/></a>';
                echo '<a class="enlace borderedondo" target="_blank" href="https://moodle.cipfpbatoi.es/"> <img alt="enlace a moodle" src="imagenes/moodle.png"/></a>';

                switch ($_SESSION['userType']) {
                    case "alumno":
                        echo '<a class="enlace borderedondo" href="automodificaralumnos.php"><img alt="Imagen editar perfil" src="imagenes/editarperfil.PNG"/></a>';
                        echo '<a class="enlace borderedondo" href="altaAlumnoManipulador.php"> <img alt="imagen manipulador alimentos" src="imagenes/manipuladoralimentos.png"/></a><br>';
                        break;
                    case "profesor":
                        echo '<a class="enlace borderedondo" href="automodificarprofesores.php"><img alt="imagen editar perfil"  src="imagenes/editarperfil.PNG"/></a>';
                        echo '<a class="enlace borderedondo" href="panelActividades.php"><img alt="actividades extraescolares" src="imagenes/actividadesextraescolar.png"/></a>';
                        echo '<a class="enlace borderedondo" href="comisionServicios.php"><img alt="gestionar grupos" src="imagenes/comisionServicios.png"/></a>';
                        break;
                    case "direccion":
                        echo '<a class="enlace borderedondo" href="automodificarprofesores.php"><img alt="editar perfil" src="imagenes/editarperfil.PNG"/></a>';
                        echo '<a class="enlace borderedondo" href="panelManipulador.php"> <img alt="manipulador alimentos" src="imagenes/manipuladoralimentos.png"/></a>';
                        echo '<a class="enlace borderedondo" href="modificarAlumnos.php"><img alt="editar alumnos" src="imagenes/editaralumnos.png"/></a>';
                        echo '<a class="enlace borderedondo" href="modificarProfesores.php"><img alt="editar profesores" src="imagenes/editarprofesores.png"/></a>';
                        echo '<a class="enlace borderedondo" href="darAltaProfesores.php"><img alt="dar de alta profesores" src="imagenes/derdealtaprofesores.png"/></a>';
                        echo '<a class="enlace borderedondo" href="panelActividades.php"><img alt="actividades extraescolares" src="imagenes/actividadesextraescolar.png"/></a>';
                        echo '<a class="enlace borderedondo" href="gestionarGrupos.php"><img alt="gestionar grupos" src="imagenes/gestiongrupo.png"/></a>';
                        echo '<a class="enlace borderedondo" href="comisionServicios.php"><img alt="gestionar grupos" src="imagenes/comisionServicios.png"/></a>';
                        echo '<a class="enlace borderedondo" href="certificadoRiesgosLaborales.php"><img alt="gestionar grupos" src="imagenes/certificadoRiesgosLaborales.png"/></a>';
                        break;
                }
                ?>

            </div>
        </div>




        <?php
        include "pie.php";
        ?>

    </body>
</html>
