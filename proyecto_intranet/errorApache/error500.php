<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>ERROR 500</title>
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
                        <h2 class="negro">¡ERROR INTERNO DEL SERVIDOR!</h2>
                        <h3 class="negro">Motivo: El servidor ha encontrado un <span>error interno</span> o <span>configuración inválida</span>, siendo imposible completar la petición</h3>
                    </div><br>

                    <div class="detalles">
                        <p><strong>Rogamos póngase en contacto con el "Administrador" del sitio web.</strong></p>
                        <p> <strong> Más información sobre dicho error "disponible" en la carpeta de informes del servidor. </strong></p>
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
