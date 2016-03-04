
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Modificar perfil</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/webcam.js"></script>
        <script type="text/javascript" src="js/lib/modificarAutoProfesores.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediaautoalumnos.css">
    </head>
    <body>
 
        <?php
        session_start();
        include("cabecera.php");
        ?>
        <br>
        <div class="formularionormal borderedondo">
        <div class="contenedor">
        <form id="automodificado" action="php/testwebcam.php" method="post" enctype="multipart/form-data">
 
            <br>
            <h1 class="centrado bloque centrado"> MODIFICACIÓN DE PERFIL</h1><br>
             
            <div class="nivel">
                <label for="email"> Email: *</label>
                <input id="email" type="email" name="email" required placeholder="Dirección de correo"/>
            </div>

            <div class="nivel">
                <label for="emailalumnos"> Email para los alumnos:</label>
                <input id="emailalumnos" type="text" name="emailalumnos" placeholder="Email para los alumnos" />
            </div>
 
            <div class="nivel">
                <label for="antiguapass"> Contraseña anterior: </label>
                <input id="antiguapass" type="password" name="antiguapass" placeholder="minimo 8 caracteres" />
            </div>

            <div class="nivel">
                <label for="pass"> Nueva contraseña: </label>
                <input id="pass" type="password" name="pass" placeholder="minimo 8 caracteres" />
            </div>

            <div class="nivel">
                <label for="confirmacion">Confirmación de la contraseña: </label>
                <input id="confirmacion" type="password" name="confirmacion" placeholder="repita la contraseña" />
            </div>
 
            <div class="nivel">
                <video hidden="true" id="video" width="250" height="160" autoplay></video><br class="oculto"><br class="oculto"><br class="oculto"><br class="oculto"><br class="oculto"><br class="oculto"><br class="oculto">
                <button hidden="true" id="snap">Snap Photo</button>
                <canvas style="border: 1px solid black;" hidden="true" id="canvas" width="250" height="160"></canvas>
            </div>
             
             <div class="nivel">
                <label for="webcam"><br> Selecciona la imagen que desees subir.</label>
                <input class="botonnormal bloque" style="height:25px;" id="webcam" type="button" value="Usar Webcam">
            </div>

            <div class="nivel">
                <label for="file"><br> Selecciona la imagen que desees subir.</label>
                <input class="botonnormal bloque reduccion" style="height:25px;" id="file" type="file" value="Subir foto">
            </div>            

            <input id="submit" class="boton" type="submit" value="Enviar">

        </form>

        </div>
        </div>

        <?php 
            include "pie.php";
         ?>
 
    </body>
</html>
