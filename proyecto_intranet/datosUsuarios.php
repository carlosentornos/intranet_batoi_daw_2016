<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>formulario de registro de alumnos</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/webcam.js"></script>
        <script type="text/javascript" src="js/formFunctions.js"></script>
        <script type="text/javascript" src="js/datosUsuarios.js"></script>
    </head>
    <body>

        <form action="php/gestion_direccionModAlum.php" method="post" enctype="multipart/form-data">

            <legend>Datos usuario</legend>
            <label for="nombre"> Escriba su nombre</label>
            <input id="nombre" type="text" name="nombre" required placeholder="escribe aquí tu nombre" autofocus /> <br/><br/>

            <label for="apellido1"> Escriba su primer apellido</label>
            <input id="apellido1" type="text" name="apellido1" required placeholder="escribe aquí tu primer apellido"/> <br/><br/>

            <label for="apellido2"> Escriba su segundo apellido</label>
            <input id="apellido2" type="text" name="apellido2" required placeholder="escribe aquí tu segundo apellido"/> <br/><br/>

            <label for="dni"> Escriba su DNI</label>
            <input id="dni" type="text" name="dni" required placeholder="8 numeros 1 letra sin espacios"/> <br/><br/>

            <label for="nia"> Escriba su NIA</label>
            <input id="nia" type="pattern" name="nia" required placeholder="Numero de identificación de alumno"/> <br/><br/>

            <label for="pass">Escriba su contraseña  </label>
            <input id="pass" type="password" name="pass" placeholder="minimo 8 caracteres" required /> <br/><br/>

            <label for="confirmacion">Escriba su contraseña  </label>
            <input id="confirmacion" type="password" name="confirmacion" placeholder="repita la contraseña" required /> <br/><br/>

            <label for="grupo"> Escriba el grupo al que pertenece</label>
            <input id="grupo" type="text" name="grupo" required /> <br/><br/>

            <label for="nacimiento"> Escriba su fecha de nacimiento</label>
            <input id="nacimiento" type="text" name="nacimiento" required /> <br/><br/>

            <video hidden="true" id="video" width="250" height="160" autoplay></video>
            <button hidden="true" id="snap">Snap Photo</button>
            <canvas style="border: 1px solid black;" hidden="true" id="canvas" width="250" height="160"></canvas><br/>
            
            <input id="webcam" type="button" value="Usar Webcam">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input id="submit" type="submit" value="Enviar formulario" name="submit">
        </form>

    </body>
</html>