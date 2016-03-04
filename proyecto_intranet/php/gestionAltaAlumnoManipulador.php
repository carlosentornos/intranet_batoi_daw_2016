<?php

session_start();
require_once "Classes/Class_DB.php";


if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion del sistema si no estas previamente identificado";
    header("Location:../login.php");
} else {
    if ($_SESSION['userType'] != "alumno") {
        header("Location:../controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los alumnos.";
    }

    include 'config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();

    if ($_POST['dato'] === 'Registrarse') {
        AltaAlumnoCurso($_POST['curso']);
    } else {
        BajaAlumnoCurso();
    }
    echo "altaAlumnoManipulador.php";
}

/**
 * Esta funcion se utilizará para dar de baja un alumno de un curso de manipulador de alimentos determinado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 */

function BajaAlumnoCurso() {
	global $conn;
    $id = $_SESSION['userId'];
    
    $curso=getCursoActivoAlumno();
    $registros = getCountRegistros($curso);
    
    $query = "DELETE FROM alumnos_has_manipulador_alimentos where alumnos_id=$id and manipulador_alimentos_codigo='$curso'";
    $result = $conn->query($query);

    if ($result) {
        if ($registros > 100) {
            $result = UpdateRegistradosCurso($curso);
        }
    }
}

/**
 * Esta funcion se utilizará para dar de alta un alumno en un curso determinado de manipulador de alimentos.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $curso El parametro de esta funcion recogera el curso de manipulador de alimentos.
 */
function AltaAlumnoCurso($curso) {
    $id = $_SESSION['userId'];

    global $conn;

    if (checkAlumnoHasCurso()) {
        SendJSON('error', ' Usted ya está registrado en un curso actualmente.');
    } else {
        $registros = getCountRegistros($curso);

        if ($registros < 100) {
            $registrado = 's';
        } else {
            $registrado = 'n';
        }

        $query = "INSERT INTO alumnos_has_manipulador_alimentos VALUES ($id,'$curso',1,'$registrado')";
        $result = $conn->query($query);
    }
}

/**
 * Esta funcion se utilizará para saber si un alumno ya tiene un curso asociado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @return boolean Esta funcion devolverá un true si tiene curso asociado o un false si no lo tiene.
 */

function checkAlumnoHasCurso() {
    $id = $_SESSION['userId'];

    global $conn;

    $query = "SELECT alumnos_id FROM alumnos_has_manipulador_alimentos as ah inner join manipulador_alimentos as ma on ah.manipulador_alimentos_codigo=ma.codigo WHERE ah.alumnos_id=$id and ma.activo='s'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return true; //si que tiene curso asociado
    } else {
        return false; // no tiene curso asociado
    }
}

/**
 * Esta funcion se utilizará para saber la cantidad de registrados que hay en un curso determinado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $curso El parametro de esta funcion recogera el curso de manipulador de alimentos.
 * @return int Esta funcion devuelve la cantidad de registros.
 */

function getCountRegistros($curso) {
    global $conn;

    $query = "SELECT count(*) as registros FROM alumnos_has_manipulador_alimentos WHERE manipulador_alimentos_codigo='$curso'";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['registros'];
        }
        return $val;
    } else {
        return 0;
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

/**
 * Esta funcion se utilizará para actualizar el primero de la lista de espera.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $curso El parametro de esta funcion recogera el curso de manipulador de alimentos.
 * @return type Esta funcion devolvera true si todo ha ido bien.
 */
function UpdateRegistradosCurso($curso) {
    global $conn;
    $alumno = getFirstWaitingList($curso);
    $query = "Update alumnos_has_manipulador_alimentos as ah inner join manipulador_alimentos as ma on ah.manipulador_alimentos_codigo=ma.codigo set ah.registrado='s' where alumnos_id=$alumno and ma.codigo='$curso'";
    $result = $conn->query($query);
    return $result;
}
/**
 * Esta funcion se utilizará para recoger el primer alumno que esta en lista de espera de un curso determinado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $curso El parametro de esta funcion recogera el curso de manipulador de alimentos.
 * @return type Esta funcion devolvera el identificador del alumno.
 */
function getFirstWaitingList($curso) {
    global $conn;

    $query = "SELECT ah.alumnos_id FROM alumnos_has_manipulador_alimentos as ah inner join manipulador_alimentos as ma on ah.manipulador_alimentos_codigo=ma.codigo WHERE ah.registrado='n' and ma.codigo='$curso' limit 1";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['alumnos_id'];
        }
        return $val;
    }
}

/**
 * Esta funcion se utilizará para recoger el codigo del curso donde el alumno esta registrado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @return type Esta funcion devolvera el codigo del curso
 */
function getCursoActivoAlumno(){
    global $conn;
    $id= $_SESSION['userId'];
    $query = "SELECT ah.manipulador_alimentos_codigo FROM alumnos_has_manipulador_alimentos as ah inner join manipulador_alimentos as ma on ah.manipulador_alimentos_codigo=ma.codigo WHERE ah.alumnos_id=$id and ma.activo='s'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $val = $row['manipulador_alimentos_codigo'];
        }
        return $val;
    }
}

?>
