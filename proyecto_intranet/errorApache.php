
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Error Apache</title>
        <script type="text/javascript" src="" ></script>
        <script type="text/javascript" src=""></script>
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
            <div class="contenedor">
                <div class="error_apache">
                    
                    <br><div class="titulo_error">
                        <h2 class="negro">¡ACCESO NO AUTORIZADO!</h2>
                        <h3 class="negro">Motivo: el usuario o el password son <span>incorrectos</span></h3>
                    </div><br>

                    <div class="detalles">
                        <p><strong>Su solicitud no ha sido atendida porque no está autorizado para acceder al recurso.</strong></p>
                        <p> <strong> Rogamos póngase en contacto con el "Administrador" del sitio web. </strong></p>
                    </div>

                    <div id="boton">
                        <input type="button" id="btn_volver" value="VOLVER" class="noFlotar" class="rojo">
                    </div>
                </div>
                
                
            </div>
        </div>

        <?php 
            include "pie.php";
         ?>
 
    </body>
</html>
