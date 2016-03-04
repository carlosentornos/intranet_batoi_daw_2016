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

    altaActividadExtraescolar();
}
/**
 * Recoje los datos por post y los inserta o actualiza en sus respectivas tablas
 * @global type $conn
 */
function altaActividadExtraescolar() {
    global $conn;
    //variables que vienen del formulario

    $nombreActividad = $_POST['nombreActividad'];
    $fechaActividad = $_POST['fechaActividad'];
    $fechaAlta = $_POST['fechaAlta'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];
    $profesores = $_POST['profesores'];
    $grupos = $_POST['grupos'];
    $cordinacion = $_POST['coordinador'];
    $comentarios = $_POST['comentarios'];
    $objetivos = $_POST['objetivos'];
    $descripcion = $_POST['descripcion'];


    //query con el insert de la actividad
    $queryInsertActividad = "INSERT INTO actividades_extraescolares VALUES ("
            . "'','$nombreActividad','$descripcion','$objetivos','$fechaActividad',"
            . "'$horaInicio','$horaFin','$fechaAlta','$comentarios'"
            . ");";
    $result = $conn->query($queryInsertActividad);
   // echo $conn->error();
    //insert relacion profesores_actividad
    if ($result) {
        $ultimoActividadCodigo = getUltimoActividadCodigo();
        //habra que hacer inserts en la relacion de actividades_extraescolares_has_profesores, primero se necesita el codigo de la actividad, es decir la ultima introducida
        $queryInsertProfesoresActividad = "INSERT INTO actividades_extraescolares_has_profesores VALUES ";
        for ($index = 0; $index < count($profesores); $index++) {
            if (count($profesores) === $index + 1) {
                //en la ultima pasada no se necesita la coma final
                $queryInsertProfesoresActividad .= "('$ultimoActividadCodigo','$profesores[$index]','0')";
            } else {
                $queryInsertProfesoresActividad .= "('$ultimoActividadCodigo','$profesores[$index]','0'),";
            }
        }
        $conn->query($queryInsertProfesoresActividad);
    }
    
    //insert relacion grupos_actividad
    if ($result) {
        $queryInsertGruposActividad = "INSERT INTO grupos_has_actividades_extraescolares VALUES ";
        for ($index1 = 0; $index1 < count($grupos); $index1++) {
            if (count($grupos) === $index1 + 1) {
                $queryInsertGruposActividad .= "((SELECT codigo from grupos where nombre = '$grupos[$index1]'),'$ultimoActividadCodigo')";
            } else {
                $queryInsertGruposActividad .= "((SELECT codigo from grupos where nombre = '$grupos[$index1]'),'$ultimoActividadCodigo'),";
            }
        }
        //echo $queryInsertGruposActividad;
        $conn->query($queryInsertGruposActividad);
        $queryCord = "UPDATE `actividades_extraescolares_has_profesores` SET `coordinador`=1 WHERE profesores_codigo=$cordinacion and `actividades_extraescolares_codigo` = ".getUltimoActividadCodigo();
        $conn->query($queryCord);
        //echo $queryCord;
        SendJSON("ok","Los datos se han guardado correctamente.");
    }else{
        SendJSON("error", "Ha habido un problema con la base de datos.");
    }
    
}

/**
 * Envia el JSON de errores para saber si todo ha ido correctamente o no
 * @param String $key Es una string error y ok
 * @param String $value datos que se le devuelve
 */
function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
/**
 * Devuelve la ultima actividad
 * @global String $conn
 * @return String El codigo de la ultima actividad
 */
function getUltimoActividadCodigo() {
    global $conn;
    $query = "select codigo from actividades_extraescolares ORDER BY codigo DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['codigo'];
        }
        return $val;
    }
}
