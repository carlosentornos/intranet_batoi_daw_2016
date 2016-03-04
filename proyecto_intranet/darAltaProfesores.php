<!DOCTYPE html>
<?php

    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['error']="No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
        header("Location:Login.php");
    }else{
        if($_SESSION['userType']!="direccion"){
            header("Location:controlPanel.php");
            $_SESSION['error']="No dispones de suficientes permisos para poder editar los datos de los alumnos.";
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dar de alta profesores</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/webcam.js"></script>
        <script type="text/javascript" src="js/lib/altaprofesores.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
    </head>
    <body>
 
        <?php
        include("cabecera.php");
        ?>
        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <form id="form" method="post" enctype="multipart/form-data">         
                     
                    <h4 class="centrado"> DAR DE ALTA DE PROFESORES</h4><br>

                    <div class="nivel">
                        <label for="nombre"> Nombre del profesor: *</label>
                        <input id="nombre" type="text" name="nombre" required placeholder="Escribe aquí tu nombre"/>
                    </div>
         
                    <div class="nivel">
                        <label for="apellido1"> Primer apellido del profesor: *</label>
                        <input id="apellido1" type="text" name="apellido1" required placeholder="Escribe aquí tu primer apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}"/>
                    </div>

                    <div class="nivel">
                        <label for="apellido2"> Segundo apellido del profesor: *</label>
                        <input id="apellido2" type="text" name="apellido2" required placeholder="Escribe aquí tu segundo apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}"/>
                    </div>

                    <div class="nivel">
                        <label for="nacimiento"> Fecha de nacimiento: *</label>
                        <input id="nacimiento" type="text" name="nacimiento" required placeholder="Fecha de nacimiento" />
                    </div>

                    <div class="nivel">
                        <label for="codhorario"> Código del horario: *</label>
                        <input id="codhorario" type="text" name="codhorario" required placeholder="Código del horario" />
                    </div>
         
                    <div class="nivel">
                        <label for="email"> Email del profesor: *</label>
                        <input id="email" type="email" name="email" required placeholder="Escribe aquí dirección de correo"/>
                    </div>
         
                    <div class="nivel">
                        <label for="nacionalidad"> Seleccione la nacionalidad:</label>
                        <select id="nacionalidad" name="nacionalidad">
                        <option value="española">Española</option> 
                        <option value="extranjera">Extranjera</option> 
                        </select>
                    </div>

         
                    <div class="nivel">
                        <label for="dni"> DNI del profesor: *</label>
                        <input id="dni" type="text" name="dni" required placeholder="Empieza por 0, o X si es extrangero" pattern="[^X|0]+[0-9]+[A-Z]${10,10}"/>
                    </div>
         
                    <div class="nivel">
                        <label for="departamento"> Seleccione el departamento:</label>
                        <select id="departamento" name="departamento"> </select>
                    </div>

                    <div class="nivel">
                        <label for="pass"> Nueva contraseña: * </label>
                        <input id="pass" type="password" name="pass" placeholder="minimo 8 caracteres" required pattern="{2,60}"/>
                    </div>
         
                    <div class="nivel">
                        <label for="confirmacion">Confirmación de la contraseña: * </label>
                        <input id="confirmacion" type="password" name="confirmacion" placeholder="repita la contraseña" required pattern="{2,60}"/>
                    </div>
                         
                    <div class="nivel">
                        <label for="codpostal"> Código postal:</label>
                        <input id="codpostal" type="text" name="codpostal" placeholder="Código postal" pattern="[0-9]{0,5}" />
                    </div>
         
                    <div class="nivel">
                        <label for="domicilio"> Domicilio: *</label>
                        <input id="domicilio" type="text" name="domicilio" required placeholder="Domicilio" />
                    </div>
         
                    <div class="nivel">
                        <label for="domicilioparticular"> Domicilio particular:</label>
                        <input id="domicilioparticular" type="text" name="domicilioparticular" placeholder="Domicilio particular" />
                    </div>
         
                    <div class="nivel">
                        <label for="provincia"> Provincia: *</label>
                        <input id="provincia" type="text" name="provincia" required placeholder="Provincia" />
                    </div>
         
                    <div class="nivel">
                        <label for="municipio"> Municipio: *</label>
                        <input id="municipio" type="text" name="municipio" required placeholder="Municipio" />
                    </div>
         
                    <div class="nivel">
                        <label for="telefono"> Teléfono principal: *</label>
                        <input id="telefono" type="tel" name="telefono" required placeholder="Numero de telefono" pattern="[0-9]{9,9}" />
                    </div>
         
                   <div class="nivel">
                        <label for="telefono2"> Teléfono secundario:</label>
                        <input id="telefono2" type="tel" name="telefono2" placeholder="Segundo numero de telefono" pattern="[0-9]{0,9}"/>
                    </div>
         

                    <div class="nivel">
                        <label for="fechadeingreso"> Fecha de ingreso: *</label>
                        <input id="fechadeingreso" type="text" name="fechadeingreso" required placeholder="Fecha de ingreso:" />
                    </div>
         
                    <div class="nivel">
                        <label for="fechaantiguedad"> Fecha de antiguedad:</label>
                        <input id="fechaantiguedad" type="text" name="fechaantiguedad" placeholder="Fecha antiguedad:" />
                    </div>
         
                    <div class="nivel">
                        <label for="fechadebaja"> Fecha de la baja:</label>
                        <input id="fechadebaja" type="text" name="fechadebaja" placeholder="Fecha de baja:" />
                    </div>
         
                    <div class="nivel">
                        <label for="emailalumnos"> Email para los alumnos: *</label>
                        <input id="emailalumnos" type="email" name="emailalumnos" required placeholder="Email para los alumnos" />
                    </div>
                     
                    <div class="nivel">
                        <label for="sexo"> Seleccione el sexo:</label>
                        <select id="sexo" name="sexo">
                            <option value="h">Hombre</option> 
                            <option value="m">Mujer</option>               
                        </select>
                    </div>
                    
                    <div class="nivel">
                        <label for="perfilacceso"> Perfil de acceso:</label>
                        <select id="perfilacceso" name="perfilacceso">
                            <option value="profesor">Profesor</option> 
                            <option value="direccion">Dirección</option>               
                        </select>
                    </div>
                    
                    <div class="nivel">
                        <label for="sustituyea"> Sustituye a:</label>
                        <select id="sustituyea" name="sustituyea">
                            
                        </select>
                    </div>
         
                    <div class="nivel">
                        <video hidden="true" id="video" width="250" height="160" autoplay></video>
                        <button hidden="true" id="snap">Snap Photo</button>
                        <canvas style="border: 1px solid black;" hidden="true" id="canvas" width="250" height="160"></canvas>
                    </div>
                     
                    <div class="nivel">
                        <label for="webcam"> Selecciona la imagen que desees subir.</label>
                        <input id="webcam" class="botonnormal" type="button" value="Usar Webcam">
                    </div>

                    <div class="nivel">
                        <input type="file" name="fileToUpload" id="fileToUpload">
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