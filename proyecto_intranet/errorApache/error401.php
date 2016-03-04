<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>ERROR 401</title>
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">
    <link rel="stylesheet" type="text/css" href="../css/mediaApache.css">
    <script type="text/javascript" src="../js/lib/jquery-2.2.0.js"></script>
    <script type="text/javascript" src="../js/lib/errorApache.js"></script>

</head>
<body>
 
        <header>
            <div id="cabecera" class="borderedondo">
                <a href="controlPanel.php"><img src="css/mapaimagen.png" class="imagenflexible"></a>
                <div id="sesion">
                    <?php
                    if (!$_SESSION) {
                        echo '<a href="login.php">Iniciar sesion</a>';
                    } else {
                        if (!isset($_SESSION['user'])) {
                            $_SESSION['error'] = "No puedes acceder a páginas de administración si no estas previamente identificado.";
                            //$_SESSION['error']="No pots accedir a págines d'adminitraçió si no estas previament identificat.";
                            header("Location: login.php");
                        } else {
                            echo '<p>' . $_SESSION['user'] . ' ' . $_SESSION['apellido1'] . ' - ' . $_SESSION['userType'] . '</p>';

                            echo '<div class="alineacion_centrada"><a href="./login.php" class="azul"> <img class="iconopequeno" src="../imagenes/home.svg"></a> <a href="php/desconexion.php"> <img class="iconopequeno" src="../imagenes/cerrarSesion.png"></a> </div>';
                        }
                    }
                    ?>

                </div>
            </div>
        </header>

        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <div class="error_apache">
                    
                    <br><div class="titulo_error">
                        <h2 class="negro">¡ACCESO NO AUTORIZADO!</h2>
                        <h3 class="negro">Motivo: el usuario o el password son <span>incorrectos</span></h3>
                    </div><br>

                    <div class="detalles">
                        <p><strong>Su solicitud no ha sido aceptada porque no está autorizado para acceder al recurso.</strong></p>
                        <p> <strong> Rogamos póngase en contacto con el "Administrador" del sitio web. </strong></p>
                    </div>

                    <div id="boton">
                        <input type="button" id="btn_volver" value="VOLVER" class="noFlotar" class="rojo">
                    </div>
                </div>
                
                
            </div>
        </div>

        <br>
        <div id="pie" class="borderedondo">
            <footer class="centrado">
                <p> 
                    <div class="salto">
                        <strong>Horario de secretaria :</strong> Mañana :De lunes a viernes de 9:00 h. a 14:00 h. Tarde martes, miercoles y jueves de 16:00 h. a 19:00 h.
                    </div><br>

                    <div class="salto">
                        <img alt="telefono" class="iconopequeno" src="../imagenes/telefono.png"><strong>Teléfono:</strong> 966 52 76 60 - 966 52 76 63
                    </div>

                    <div class="salto">
                        <img alt="direccion" class="iconopequeno" src="../imagenes/direccion.png"><strong>Dirección:</strong> Carrer la Serreta, 5, 03802 Alcoi, Alicante.
                    </div><br>
                    
                    <br>

                    <strong>© 2016 CIPFPBATOI</strong>
                        
                </p>
            </footer>
        </div>
 
    </body>
</html>
