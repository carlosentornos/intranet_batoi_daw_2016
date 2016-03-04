
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Panel actividades</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/panelActividades.js"></script>
        <script type="text/javascript" src="js/lib/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/mediamodificaciondireccion.css">
        <link rel="stylesheet" type="text/css" href="js/lib/jquery-ui.min.css">
    </head>
    <body>

        <?php
        session_start();
        include("cabecera.php");
        ?>

        <br>
        <div class="formularionormal borderedondo">
            <div class="contenedor">
                <br>
                <h4 class="centrado" > ACTIVIDADES EXTRAESCOLARES </h4><br>
                <div id="contenedorbotones" class="centrado">
                    <button class="button nuevaAlta">ALTA ACTIVIDAD</button>
                    <button class="button" id="generarPermiso">AUTORIZA. MENORES</button>
                </div>

                <form>
                    <div class="panel_manipulador">
                        <label for="filtro">FILTRO</label>
                        <select id="filtro" name="filtro">
                            <option>Seleccionar</option>
                        </select>
                    </div>
                    <div class="nivel datosActividades">

                        <div class="nivel">
                            <h4 class="centrado" > Datos actividad extraescolar </h4><br>
                            <div class="actividadContainer">
                                <div class="nivel">
                                    <label for="nombre"> Nombre de la actividad: *</label>
                                    <input id="nombre" type="text" name="nombre" required placeholder="Nombre de la actividad" />
                                </div>
                                <div class="nivel">
                                    <label for="fecha"> Fecha de la actividad:*</label>
                                    <input id="fecha" type="text" name="fecha" placeholder="Fecha de la actividad" />
                                </div>
                                <div class="nivel">
                                    <label for="horaInicio"> Hora de inicio:* </label>
                                    <input id="horaInicio" type="text" name="horaInicio" required placeholder="Hora de inicio" />
                                </div>
                                <div class="nivel">
                                    <label for="horaFin"> Hora de finalización:* </label>
                                    <input id="horaFin" type="text" name="horaFin" required placeholder="Hora de fin" />
                                </div>
                                <div class="nivel">
                                    <label for="fechaAlta"> Fecha de alta de la actividad:* </label>
                                    <input id="fechaAlta" type="text" name="fechaAlta" required placeholder="Fecha de alta " />
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
                            </div>
                        </div>
                        <input id="submit" class="boton" type="submit" value="Guardar datos de la actividad">
                        <div class="nivel">
                            <h4 class="centrado" > Profesores participantes </h4><br>
                            <div class="profesoresContainer">

                            </div>

                            <div class="panel_manipulador">
                                <label> AÑADIR PROFESOR:</label>
                                <input type="text" id="buscarprofesor" name="buscaralumno"/>
                                <div id="box">
                                    <ul id="ulProfContainer">

                                    </ul>
                                </div>
                                <br><br>
                            </div>
                        </div>

                        <div class="nivel">
                            <h4 class="centrado" > Grupos participantes </h4><br>
                            <div class="gruposContainer">

                            </div>
                        </div>

                        <div class="panel_manipulador">
                            <label> AÑADIR GRUPO:</label>
                            <select id="grupo" class="grupo reducir_select" name="grupo">
                            </select>
                        </div>

                    </div>



                </form>
            </div>
            <div id="tableContainer" class="tabla">

            </div>
        </div>

        <?php
        include "pie.php";
        ?>

    </body>
</html>
