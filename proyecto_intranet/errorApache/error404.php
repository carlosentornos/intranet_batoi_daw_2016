<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>ERROR 403</title>
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">
    <link rel="stylesheet" type="text/css" href="../css/mediaApache.css">
    <script type="text/javascript" src="../js/lib/jquery-2.2.0.js"></script>
    <script type="text/javascript" src="../js/lib/errorApache.js"></script>

</head>
<body>
 
        <?php
        session_start();
        include("../cabecera.php");
        ?>

        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <div class="error_apache">
                    
                    <br><div class="titulo_error">
                        <h2 class="negro">¡SE HA PRODUCIDO UN ERROR!</h2>
                        <h3 class="negro">Motivo: Archivo o recurso <span>no encontrado</span></h3>
                    </div><br>

                    <div class="detalles">
                        <p><strong>Su solicitud no ha sido aceptada debido a que no existe o posiblemente se encuentre en otro lugar.</strong></p>
                        <p> <strong>Rogamos póngase en contacto con el "Administrador" del sitio web.</strong></p>
                    </div>

                    <div id="boton">
                        <input type="button" id="btn_volver" value="VOLVER" class="noFlotar" class="rojo">
                    </div>
                </div>
                
                
            </div>
        </div>

        <?php 
            include "../pie.php";
         ?>
 
    </body>
</html>
