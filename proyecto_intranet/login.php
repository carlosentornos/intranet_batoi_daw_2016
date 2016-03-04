<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location:controlPanel.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>login</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/medialogin.css">
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/login.js"></script>

    </head>
    <body>


        <div class="formulario borderedondo alinearvertical">
            <br><h4 class="centrado" > <img alt="icono estudiante" src="imagenes/estudiante.png"><br>INICIAR SESIÓN</h4>
            <form method="post">

                <div id="envoltorio">
                    <div class="forms">
                        <label class="centrar" for="loginUser">Usuario: </label>
                        <input class="centrar" id="loginUser" type="text" name="dni" required placeholder="Escribe aquí tu usuario." autofocus /><br>
                    </div>

                    <div class="forms">
                        <label class="centrar" for="passUser">Contraseña: </label>
                        <input class="centrar" id="passUser" type="password" name="pass" placeholder="Escribe aquí tu contraseña." required/> <br>
                        <input id="btnLogin" class="boton" type="submit" value="Enviar"><br>
                        <div class="olvidarpass">
                            <a href="#">¿Olvidaste tu contraseña?</a>
                        </div>


                        <div id="errors">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<p class='error'>" . $_SESSION['error'] . "</p>";
                            }
                            ?>

                        </div>    

                    </div>



                </div>
            </form>
        </div>
        <?php
//include("pie.php");
        ?>

    </body>
</html>
