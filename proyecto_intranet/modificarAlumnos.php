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
        <title>formulario de registro de alumnos</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/webcam.js"></script>
        <script type="text/javascript" src="js/lib/modificarAlumnos.js"></script>
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
        <form id="form" action="php/gestionDirModAlum.php" method="post" enctype="multipart/form-data">
 
            <br>
            <label > SELECCION ALUMNO:</label>
            <input type="text" id="buscaralumno" name="buscaralumno"  autofocus/>
            <div id="box">
                        <ul id="ulAlumnContainer">
 
                        </ul>
                    </div>
            <br><br>
 
 
            <h4 class="centrado"> MODIFICACIÓN DE ALUMNOS</h4><br>

            <div class="nivel">
                <label for="nombre"> Nombre del alumno:</label>
                <input id="nombre" type="text" name="nombre" required placeholder="Nombre de alumno"/>
            </div>
            
            <div class="nivel">
                <label for="apellido1"> Primer apellido del alumno:</label>
                <input id="apellido1" type="text" name="apellido1" required placeholder="Primer apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}" />
            </div>

            <div class="nivel">
                <label for="apellido2"> Segundo apellido del alumno:</label>
                <input id="apellido2" type="text" name="apellido2" required placeholder="Segundo apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]{2,25}" />
            </div>
 
            <div class="nivel">
                <label for="email"> Email del alumno:</label>
                <input id="email" type="email" name="email" required placeholder="Dirección de email" />
            </div>

            <div class="nivel">
                <label for="nacionalidad"> Seleccione la nacionalidad:</label>
                <select id="nacionalidad" name="nacionalidad">
                    <option value="española">Española</option> 
                    <option value="extranjera">Extranjera</option> 
                </select>
            </div>
 
            <div class="nivel">
                <label for="dni"> DNI del alumno: *</label>
                <input id="dni" type="text" name="dni" required pattern="[^X|0]+[0-9]+[A-Z]${10,10}"/>
            </div>
 
            <div class="nivel">
                <label for="nia"> NIA del alumno: *</label>
                <input id="nia" type="text" name="nia" required placeholder="Numero de identificación de alumno" pattern="[0-9]{8,8}" />
            </div>
 
            <div class="nivel">
                <label for="nacimiento"> Fecha de nacimiento: *</label>
                <input id="nacimiento" type="text" name="fecha_nac" required placeholder="Fecha de nacimiento." />
            </div>
            
            <div class="nivel">
                <label for="expediente"> Expediente: *</label>
                <input id="expediente" type="text" name="expediente" required placeholder="Expediente" pattern="[0-9]{0,5}" />
            </div>
            
            <div class="nivel">
                <label for="codpostal"> Código postal: *</label>
                <input id="codpostal" type="text" name="cod_postal" required placeholder="Código postal" pattern="[0-9]{0,5}" />
            </div>
 
            <div class="nivel">
                <label for="domicilio"> Domicilio *</label>
                <input id="domicilio" type="text" name="domicilio" required placeholder="Domicilio" pattern="{2,45}"/>
            </div>
 
            <div class="nivel">
                <label for="provincia"> Provincia: *</label>
                <input id="provincia" type="text" name="provincia" required placeholder="Provincia" pattern="{2,100}"/>
            </div>
 
            <div class="nivel">
                <label for="municipio"> Municipio: *</label>
                <input id="municipio" type="text" name="municipio" required placeholder="Municipio" pattern="{2,100}"/>
            </div>
 
            <div class="nivel">
                <label for="telefono"> Teléfono principal: *</label>
                <input id="telefono" type="tel" name="telefono1" required placeholder="Numero de telefono" pattern="[0-9]{9,9}"/>
            </div>
 
            <div class="nivel">
                <label for="telefono2"> Teléfono secundario:</label>
                <input id="telefono2" type="tel" name="telefono2" placeholder="Segundo numero de telefono" pattern="[0-9]{9,9}"/>
            </div>
 
            <div class="nivel">
                <label for="fechamatricula"> Fecha de la matricula: *</label>
                <input id="fechamatricula" type="text" name="fecha_matricula" required placeholder="Fecha matricula" />
            </div>
 
            <div class="nivel">
                <label for="fechaingresoencentro"> Fecha de ingreso en centro: *</label>
                <input id="fechaingresoencentro" type="text" name="fecha_ingreso_centro" required placeholder="Fecha ingreso en centro" />
            </div>

            <div class="nivel">
                <label for="estadomatricula"> Estado de la matrícula:</label>
                <select id="estadomatricula" name="estadomatricula">
                    <option value="m">Matriculado</option> 
                    <option value="b">Baja</option>                
                </select>
            </div>
 
            <div class="nivel">
                <label for="repite"> ¿Actualmente repite curso?</label>
                <select id="repite" name="repite">
                    <option value="n">No</option>
                    <option value="s">Si</option> 
                </select>
            </div>
 
            <div class="nivel">
                <label for="turno"> Seleccione turno:</label>
                <select id="turno" name="turno">
                    <option value="d">Diurno</option> 
                    <option value="n">Nocturno</option>
                    <option value="s">Semipresencial</option> 
                </select>
            </div>
 
            <div class="nivel">
                <label for="trabaja"> ¿Esta trabajando?</label>
                    <select id="trabaja" name="trabaja">
                    <option value="n">No</option> 
                    <option value="s">Si</option> 
                </select>
            </div>
 
            <div class="nivel"><label for="sexo"> Seleccione sexo:</label>
                <select id="sexo" name="sexo">
                    <option value="h">Hombre</option> 
                    <option value="m">Mujer</option> 
                </select>
            </div>
 
            <div class="nivel grupoContainer">
                <label for="grupo"> Seleccione grupo:</label>
                <a href="#grupo" class="anadirGrupo"><img alt="añadir" src="imagenes/anadir.png" class="iconopequeno flotacion_derecha"></a>
                <select id="grupo" class="grupo reducir_select" name="grupo">
                </select>
            </div>

            <div class="nivel">
                <label for="observaciones"> Observaciones:</label>
                <textarea id="observaciones" name="observaciones" rows="4" cols="30" placeholder="Escribe aquí tus observaciones"></textarea>
            </div>
            
            <div class="nivel">
                <video hidden="true" id="video" width="250" height="160" autoplay></video>
                <button hidden="true" id="snap">Snap Photo</button>
                <canvas style="border: 1px solid black;" hidden="true" id="canvas" width="250" height="160"></canvas>
            </div>
             
            <div class="nivel">
                <label for="webcam"> Selecciona la imagen que desees subir:</label>
                <input class="botonnormal" id="webcam" type="button" value="Usar Webcam">
            </div>

            <div class="nivel">
                <input type="file" name="file" id="file">
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