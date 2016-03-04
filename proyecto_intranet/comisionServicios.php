
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Autorización Comisión de Servicios</title>
        <script type="text/javascript" src="js/lib/jquery-2.2.0.js" ></script>
        <script type="text/javascript" src="js/lib/formFunctions.js"></script>
        <script type="text/javascript" src="js/lib/comisionServicios.js"></script>
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
            <form method="post">

                <br><h4>SOLICITUD AUTORIZACIÓN DE COMISIÓN DE SERVICIOS</h4><br>

                <div class="nivel">
                    <label for="nombre"> Nombre del solicitante: *</label>
                    <input id="nombre" type="text" name="nombre" required placeholder="Nombre del solicitante"/>
                </div>

                <div class="nivel">
                    <label for="apellido1"> Primer apellido del solicitante: *</label>
                    <input id="apellido1" type="text" name="apellido1" required placeholder="Primer apellido del solicitante"/>
                </div>

                <div class="nivel">
                    <label for="apellido2"> Segundo apellido del solicitante: *</label>
                    <input id="apellido2" type="text" name="apellido2" required placeholder="Segundo apellido del solicitante"/>
                </div>

                <div class="nivel">
                    <label for="nif"> NIF del solicitante: *</label>
                    <input id="nif" type="text" name="nif" required placeholder="NIF"/>
                </div>

                <div class="nivel">
                    <label for="servicio"> Servicio que tiene que realizar: *</label>
                    <input id="servicio" type="text" name="servicio" required placeholder="Servicio que tiene que realizar"/>
                </div>

                <div class="nivel">
                    <label for="fechasalida"> Fecha y hora de salida: *</label>
                    <input id="fechasalida"  class="mitad_imput" type="text" name="fechasalida" required placeholder="Fecha salida"/>
                    <input id="horasalida" class="mitad_imput" type="text" name="horasalida" required placeholder="00:00"/>
                </div>

                <div class="nivel">
                    <label for="fechallegada"> Fecha y hora de vuelta: *</label>
                    <input id="fechallegada" class="mitad_imput" type="text" name="fechallegada" required placeholder="Fecha llegada"/>
                    <input id="horallegada" class="mitad_imput" type="text" name="horallegada" required placeholder="00:00"/>
                </div>

                <div class="nivel">
                    <label for="dietaalojamiento"> Dieta de alojamiento:</label>
                    <input id="dietaalojamiento" type="text" name="dietaalojamiento"  placeholder="Dieta de alojamiento"/>
                </div>

                <div class="nivel">
                    <label for="dietacomida"> Dieta de comida:</label>
                    <input id="dietacomida" type="text" name="dietacomida"  placeholder="Dieta de comida"/>
                </div>

                <div class="nivel">
                    <label for="otrosgastos"> Dieta de otros gastos:</label>
                    <input id="otrosgastos" type="text" name="otrosgastos" placeholder="Dieta de otros gastos"/>
                </div>

                <div class="nivel">
                    <label for="locomocionmedia"> Medio de locomoción: *</label>
                    <input id="locomocionmedia" type="text" name="mediolocomocion" required placeholder="Medio de locomoción"/>
                </div>

                <div class="nivel">
                    <label for="km"> Kilometraje: *</label>
                    <input id="km" type="text" name="km" required placeholder="Kilometraje"/>
                </div>

                <div class="nivel">
                    <label for="marcavehiculo"> Marca del vehículo: *</label>
                    <input id="marcavehiculo" type="text" name="marcavehiculo" required placeholder="Marca del vehículo"/>
                </div>

                <div class="nivel">
                    <label for="matricula"> Matricula del vehículo: *</label>
                    <input id="matricula" type="text" name="matricula" required placeholder="Matricula del vehículo"/>
                </div>

                <div class="nivel">
                    <label for="otrosmedios"> Otros medios: </label>
                    <select id="otrosmedios" name="otrosmedios">
                        <option value="">Seleccionar</option>
                        <option value="avion">Avion</option>
                        <option value="tren">Tren</option>
                        <option value="taxi">Taxi</option>
                        <option value="autobus">Autobús</option>
                        <option value="otros">Otros</option>
                    </select>
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
