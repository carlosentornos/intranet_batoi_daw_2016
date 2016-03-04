<?php

session_start();
require_once "Classes/Class_DB.php";
$errors;

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion del sistema si no estas previamente identificado";
    header("Location:login.php");
} else {
    if ($_SESSION['userType'] != "direccion") {
        header("Location:controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los alumnos.";
    }

    include 'config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();

    CrearCurso();
}

/**
 * Esta funcion se utilizará para validar los datos que nos lleguen del cliente.
 * @global type $errors Esta funcion utilizará la variable global errors.
 * @return type Esta funcion devolvera los errores que se encuentren en forma de array.
 */
function valData(){
    include 'Utils_Validations/Utils_Validation.php';
    global $errors;

    $fecha_ini = valDate($_POST['fechaInicio'], "Fecha de inicio");

    if ($fecha_ini != "Ok") {
        $errors[] = $fecha_ini;
    }

    $fecha_fin = valDate($_POST['fechaFin'], "Fecha de fin");

    if ($fecha_fin != "Ok") {
        $errors[] = $fecha_fin;
    }

    $horas = valHours($_POST['horas'], "Horas");

    if ($horas != "Ok") {
        $errors[] = $horas;
    }

    $turno = valScheduleTurn($_POST['horario'], "Horario");
    if ($turno != "Ok") {
        $errors[] = $turno;
    }

    $activo = valActive($_POST['activo'], "Activo");

    if ($activo != "Ok") {
        $errors[] = $activo;
    }

    $profesorado = valTeacher($_POST['profesorado'],"Profesorado");

    if($profesorado !="Ok"){
        $errors[] = $profesorado;
    }

    return $errors;
}
/**
 * Esta funcion se utilizará para crear el curso de manipulador de alimentos.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @global type $errors Esta funcion utilizará la variable global errors.
 */
function CrearCurso() {
    global $conn;
    global $errors;
    if (count(valData()) == 0) {
        $fechain = $_POST['fechaInicio'];
        $fechafin = $_POST['fechaFin'];
        $horas = $_POST['horas'];
        $activo = $_POST['activo'];
        $profesorado = $_POST['profesorado'];
        $comentarios = $_POST['comentarios'];
        $horario=$_POST['horario'];
                   
        $query = "INSERT INTO manipulador_alimentos values ('" .  getCodCurso() . "','$fechain','$fechafin','$horas','$activo','$horario','$profesorado','$comentarios')";
        //echo $query;
        $result = $conn->query($query); 

        if ($result)
            SendJSON('ok', 'Los cambios se han guardado correctamente.');
        else
            SendJSON('error', 'Ha habido un error con la base de datos, vuelva a intentarlo mas tarde o contacte con el administrador del sistema.');
    }else {
        SendJSON("error", $errors);
    }
}

/**
 * Esta funcion se utilizara para establecer el nuevo codigo del curso de manipulador de alimentos.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @return type Esta funcion devolvera el codigo del curso bien formado.
 */
function getCodCurso() {
    global $conn;

    $query = "SELECT codigo FROM manipulador_alimentos ORDER BY codigo DESC LIMIT 1";
    $result = $conn->query($query);
    date_default_timezone_set('GMT');
    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = explode("/", $row['codigo']);
        }
        $code = intval($val[0]) + 1;
        
        return getFormatCode($code, date('Y'));
    } else {
        return getFormatCode('001', date('Y'));
    }
}
/**
 * Esta funcion se utilizará para devolver el formato correcto del codigo del curso.
 * @param type $code Esta variable recogera los 3 primeros caracteres del codigo del curso.
 * @param type $year Esta variable recogera los 4 ultimos caracteres del codigo del curso.
 * @return type Esta funcion devolverá el codigo del curso formado correctamente.
 */
function getFormatCode($code, $year) {
    $code = strval($code);
    if (strlen($code) < 3) {
        if (strlen($code) < 2) {
            $code = '00' . $code;
        } else {
            $code = '0' . $code;
        }
    }
    return $code . '/' . $year;
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

