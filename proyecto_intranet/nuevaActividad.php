
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Nueva actividad</title>  
        <script type="text/javascript" src="js/lib/formFunctions.js" ></script>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js"></script>
        <script type="text/javascript" src="js/lib/nuevaActividad.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
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
                <form id="automodificado"  method="post" enctype="multipart/form-data">

                    <h4 class="centrado">Nueva Actividad Extraescolar</h4>

                    <div class="nivel">
                        <label for="nombre"> Nombre de la actividad: *</label>
                        <input id="nombre" type="text" name="nombre" required placeholder="Nombre de la actividad" />
                    </div>
                    <div class="nivel">
                        <label for="fecha"> Fecha de la actividad: *</label>
                        <input id="fecha" type="text" name="fecha" placeholder="Fecha de la actividad" />
                    </div>
                    <div class="nivel">
                        <label for="horaInicio"> Hora de inicio: *</label>
                        <input id="horaInicio" type="text" name="horaInicio" required placeholder="Hora de inicio" />
                    </div>
                    <div class="nivel">
                        <label for="horaFin"> Hora de finalización: *</label>
                        <input id="horaFin" type="text" name="horaFin" required placeholder="Hora de fin" />
                    </div>
                    <div class="nivel">
                        <label for="fechaAlta"> Fecha de alta de la actividad: *</label>
                        <input id="fechaAlta" type="text" name="fechaAlta" required placeholder="Fecha de alta " />
                    </div>
                    <div class="nivel">
                        <label for="coordinacion"> Coordinacion: *</label>
                        <select id="coordinacion" name="coordinacion">

                        </select>
                    </div>

                    <!-- buscador de profesores -->
                    <div class="nivel">
                        <label for="buscarprofesor"> Acompañantes en la actividad: *</label>
                        <input id="buscarprofesor" type="text" name="buscarprofesor" required placeholder="Acompañantes" />
                    </div>

                    <div class="nivel">
                        <select id="listaProfesores" name="listaProfesores">

                        </select>
                    </div>

                    <br><div id="box">
                        <ul id="ulProfContainer">

                        </ul>
                    </div>

                    <!-- buscador de profesores -->
                    <div class="nivel grupoContainer">
                        <label for="grupo"> Seleccione grupo: *</label>
                        <a href="#grupo" class="anadirGrupo"><img src="imagenes/anadir.png" class="iconopequeno flotacion_derecha"></a>
                        <select id="grupo" class="grupo reducir_select" name="grupo">
                        </select>
                    </div><br>

                    <div class="linea">
                        <label for="comentarios"> Comentarios:</label>
                        <textarea id="comentarios" name="comentarios" rows="4" cols="30" placeholder="Comentarios"></textarea>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="linea">
                        <label for="descripcion"> Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" cols="30" placeholder="Descripción"></textarea>
                        <div style="clear:both;"></div>
                    </div>

                    <div class="linea">
                        <label for="objetivos"> Objetivos de la actividad:</label>
                        <textarea id="objetivos" name="objetivos" rows="4" cols="30" placeholder="Objetivos"></textarea><br class="eliminar" /><br>
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
