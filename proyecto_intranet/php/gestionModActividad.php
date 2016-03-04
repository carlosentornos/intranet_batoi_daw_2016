<?php

session_start();
require_once "Classes/Class_DB.php";

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion del sistema si no estas previamente identificado";
    header("Location: ../login.php");
} else {
    if ($_SESSION['userType'] != "direccion") {
        header("Location: ../controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los alumnos.";
    }

    include 'config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();
    $conn->set_charset('utf8');

    $accion = $_POST['accion'];

    switch ($accion) {
        case 'borrarProfesorActividad':
            $codigoProfesor = $_POST['codigoProfesor'];
            $codigoActivdad = $_POST['codigoActividad'];
            $query = "DELETE FROM actividades_extraescolares_has_profesores where actividades_extraescolares_codigo = '$codigoActivdad'" .
                    " AND profesores_codigo = '$codigoProfesor'";
            //echo $query;
            ejecutarAccion($query, true);
            break;
        case 'borrarGrupoActividad' :
            $codigoActivdad = $_POST['codigoActividad'];
            $codigoGrupo = $_POST['codigoGrupo'];
            $query = "DELETE FROM grupos_has_actividades_extraescolares where grupos_codigo = '$codigoGrupo'" .
                    " AND actividades_extraescolares_codigo = '$codigoActivdad'";
            ejecutarAccion($query, true);
            break;
        case 'anadirProfesorActividad' :
            $codigoProfesor = $_POST['codigoProfesor'];
            $codigoActividad = $_POST['codigoActividad'];
            $query = "INSERT INTO actividades_extraescolares_has_profesores VALUES" .
                    " ('$codigoActividad','$codigoProfesor','0')";
            ejecutarAccion($query, true);
            break;
        case 'anadirGrupoActividad' :
            $nombreGrupo = $_POST['nombreGrupo'];
            $codigoActividad = $_POST['codigoActividad'];
            $query = "INSERT INTO grupos_has_actividades_extraescolares VALUES" .
                    " ((SELECT codigo from grupos where nombre = '$nombreGrupo'),'$codigoActividad')";

            ejecutarAccion($query, true);
            break;
        case 'cambiarCoordinador' :
            $codigoProfesor = $_POST['codigoProfesor'];
            $codigoActividad = $_POST['codigoActividad'];

            $query = "update actividades_extraescolares_has_profesores set coordinador = '0' where coordinador = '1' AND actividades_extraescolares_codigo = '$codigoActividad'";
            ejecutarAccion($query, true);
            $query = "update actividades_extraescolares_has_profesores set coordinador = '1' where profesores_codigo = '$codigoProfesor' AND actividades_extraescolares_codigo = '$codigoActividad'";
            ejecutarAccion($query, false);
            break;
        case 'modificarDatosActividadExtraescolar':
            $codigoActividad = $_POST['codigoActividad'];
            modificarActividadExtraescolar($codigoActividad);
            break;
    }
}
/**
 * Esta funcion se utilizará para comprobar que la query haya funcionado correctamente.
 * @global type $conn
 * @param type $query
 * @return boolean
 */
function comprobarBool($query) {
    global $conn;
    $result = $conn->query($query);
    if ($result->num_rows !== 0) {
        return true;
    } else {
        return false;
    }
}
/**
 * Esta funcion se utilizara para generar las queries y generar el posterior mensaje que el usuario recibirá por pantalla.
 * @global type $conn
 * @param type $query
 * @param type $bool Este parametro será necesario para indicar si se quiere generar el reporte o no.
 */
function ejecutarAccion($query, $bool) {
    global $conn;
    $success = $conn->query($query);

    if ($bool) {
        if ($success) {
            //echo "correcto";
            SendJSON('ok', 'Cambio realizado con éxito');
        } else {
            //echo "error";
            SendJSON('error', 'No se pudo ejecutar la consulta');
        }
    }
}
/**
 * Esta funcion se utilizará para modificar los datos de una actividad extraescolar determinada.
 * @global type $conn
 * @param type $codigoActividad Este parametro recogerá el codigo de la actividad extraescolar.
 */
function modificarActividadExtraescolar($codigoActividad) {
    global $conn;
    //variables que vienen del formulario
    $nombreActividad = $_POST['nombreActividad'];
    $fechaActividad = $_POST['fechaActividad'];
    $fechaAlta = $_POST['fechaAlta'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];
    $comentarios = $_POST['comentarios'];
    $objetivos = $_POST['objetivos'];
    $descripcion = $_POST['descripcion'];
    
    $query = "UPDATE actividades_extraescolares set"
            . " nombre='$nombreActividad',"
            . " descripcion='$descripcion',"
            . " objetivos='$objetivos',"
            . " fecha_realizacion='$fechaActividad',"
            . " hora_inicio='$horaInicio',"
            . " hora_fin='$horaFin',"
            . " fecha_alta='$fechaAlta',"
            . " comentarios='$comentarios'"
            . " WHERE codigo = '$codigoActividad'";
    
    $result = $conn->query($query);
    
    if ($result) {
        SendJSON('ok','Cambios realizaods con éxito');
    } else {
        SendJSON('ok','Los cambios no pudieron ser realizados');
    }
    
}
/**
 * Esta funcion se utilizará para generar el reporte final al cliente
 * @param type $key Esta variable recogerá un "ok" o un "error", dependiendo del tipo de mensaje especificado.
 * @param type $value Esta variable recogerá el mensaje que se le mostrará al cliente.
 */
function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
