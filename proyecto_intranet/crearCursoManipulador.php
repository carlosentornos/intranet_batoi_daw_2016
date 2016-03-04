<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Nuevo curso manipulador de alimentos</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.js"></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/crearCursoManipuladorAlimentos.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.css">
    </head>
    <body>
 
        <?php
        session_start();
        include("cabecera.php");
        ?>

        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <form id="automodificado" method="post" enctype="multipart/form-data">

                    <br><h4>CREACION DE CURSO MANIPULADOR DE ALIMENTOS</h4><br>

                    <div class="nivel">
                        <label for="fecha"> Fecha de inicio de la actividad:</label>
                        <input id="fecha" type="text" name="fecha" placeholder="Fecha de inicio" autofocus required/>
                    </div>

                    <div class="nivel">
                        <label for="fechaFin"> fecha de finalización: *</label>
                        <input id="fechaFin" type="text" name="horaFin" required placeholder="Fecha de finalización" />
                    </div>

                    <div class="nivel">
                        <label for="horas"> Numero de horas: *</label>
                        <input id="horas" type="text" name="horas" required placeholder="Numero de horas" />
                    </div>

                    <div class="nivel">
                        <label for="activo">¿Esta activo el curso?</label>
                        <select id="activo" name="activo">
                            <option value="S">Si</option>
                            <option value="N">No</option>
                        </select>
                    </div>


<!-- CARLOS -->     <div class="nivel">
                        <label for="buscarprofesor"> SELECCION PROFESOR:</label>
                        <input type="text" placeholder="" id="buscarprofesor" name="buscarprofesor" />
                        <div id="box">
                            <ul id="ulProfeContainer">
             
                            </ul>
                        </div>
                    </div>

                    <div class="nivel">
                        <label for="profesorado"> profesorado:</label>
                        <select id="profesorado" name="profesorado">
                            
                        </select>
                        
                    </div>
                    
<!-- CARLOS -->     

                    <div class="nivel">
                        <label for="comentarios"> Comentarios:</label>
                        <textarea id="comentarios" name="comentarios" rows="4" cols="30" placeholder="Comentarios"></textarea>
                        <div class="clear"></div>
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
