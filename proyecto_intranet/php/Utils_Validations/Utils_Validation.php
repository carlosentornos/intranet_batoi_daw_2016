<?php

require_once "./Classes/Class_DB.php";

include './config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();

/**
 * Valida el nombre y el apellido
 * @param String $name variable que recibo 
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valNameSurname($name, $namefield) {
    if (strlen(trim($name)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($name)) > 25) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida la contraseña
 * @param String $pass variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error y Ok
 */
function valPassword($pass, $namefield) {
    if (strlen(trim($pass)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($pass)) > 60) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el dni y si es español o extranjero
 * @param String $dni variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valDni($dni, $namefield) {
    $first = substr($dni, 0, 1);
    if ($first == "0" || $first == "X") {
        $aux = substr($dni, 1, 10);
        if (strlen($aux) != 9 || preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $aux, $matches) !== 1) {
            return personalizedErrors($namefield . "1", '2');
        } else {
            return "Ok";
        }
    } else {
        return personalizedErrors($namefield . "2", '2');
    }
}

/**
 *  Valido el email
 * @param String $email variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valEmail($email, $namefield) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || (strlen(trim($email)) == 0 || strlen(trim($email) > 45))) {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida las horas
 * @param String $hours variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valHours($hours, $namefield) {
    if (!preg_match("/^[0-9]+$/i", trim($hours))) {
        return personalizedErrors($namefield, '3');
    } elseif (strlen(trim($hours)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($hours)) > 3) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida si esta activo 
 * @param String $active variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valActive($active, $namefield) {
    if (trim($active) == 'S' || trim($active) == 'N') {
        return "Ok";
    } else {
        return personalizedErrors($namefield, '2');
    }
}

/**
 * Valida la fecha 
 * @param String $date variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valDate($date, $namefield) {
    $arr = split("-", $date);
    $yy = $arr[0];
    $mm = $arr[1];
    $dd = $arr[2];
    if (!checkdate($mm, $dd, $yy)) {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida si viene vacio y si no viene se comprueba que este bien formado
 * @param String $date variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valDateNotRequired($date, $namefield) {

    if (strlen($date) != 0) {
        $arr = split("-", $date);
        $yy = $arr[0];
        $mm = $arr[1];
        $dd = $arr[2];
        if (!checkdate($mm, $dd, $yy)) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return "Ok";
    }
}

/**
 * Valida el NIA
 * @param String $nia variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valNia($nia, $namefield) {
    if (!preg_match("/[0-9]{8}/", trim($nia)) || strlen(trim($nia)) != 8) {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida genero
 * @param String $data variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valGender($data, $namefield) {
    if (strtoupper(trim($data)) == 'M' || strtoupper(trim($data)) == 'H') {
        return "Ok";
    } else {
        return personalizedErrors($namefield, '2');
    }
}

/**
 * Valida el Estado
 * @param String $data variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valRegisterState($data, $namefield) {
    if (strlen(trim($data)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($data)) > 1) {
        return personalizedErrors($namefield, '1');
    } elseif (strtoupper(trim($data)) != 'M' && strtoupper(trim($data)) != 'B') {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida cuantas veces repite 
 * @param String $data variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valRepeat($data, $namefield) {
    if (!preg_match("/^[0-9]+$/i", trim($data))) {
        return personalizedErrors($namefield, '3');
    } else {
        return "Ok";
    }
}

/**
 * Valida si trabaja o no
 * @param String $data variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valWorking($data, $namefield) {
    if (strtoupper(trim($data)) != 'S' && strtoupper(trim($data)) != 'N') {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida el codigo postal
 * @param String $string variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valZipCode($string, $namefield) {
    if (strlen(trim($string)) != 0) {
        if (!preg_match("/^[0-9]+$/i", trim($string)) && strlen(trim($string)) != 5) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return "Ok";
    }
}

/**
 * Valida la calle
 * @param String $address variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valAddress($address, $namefield) {
    if (strlen(trim($address)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($address)) > 45) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida si no viene y si viene lo valida
 * @param String $address variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valAddressNotRequired($address, $namefield) {
    if (strlen(trim($address)) == 0) {
        return "Ok";
    } elseif (strlen(trim($address)) > 45) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida la provincia
 * @param String $province variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function val_Province($province, $namefield) {
    if (strlen(trim($province)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($province)) > 100) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida la ciudad
 * @param String $city variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function val_City($city, $namefield) {
    if (strlen(trim($city)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($city)) > 100) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el telefono
 * @param String $telephone variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valTelephone($telephone, $namefield) {
    if (strlen(trim($telephone)) != 0) {
        if (!preg_match("/^[0-9]+$/i", trim($telephone)) && strlen(trim($telephone)) != 9) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return "Ok";
    }
}

/**
 * Valida las observaciones
 * @param String $observations variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valObservations($observations, $namefield) {
    if (strlen(trim($observations)) > 45) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el codigo de horario
 * @param String $TC variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valTimetableCode($TC, $namefield) {
    if (!preg_match("/^[0-9]+$/i", trim($TC))) {
        return personalizedErrors($namefield, '2');
    } elseif (strlen(trim($TC)) < 1) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($TC)) > 3) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el departamento
 * @param String $department variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valDepartment($department, $namefield) {
    if (!preg_match("/^[0-9a-zA-ZñÑáäëéèíïöóòúüçÄÁËÉÈÏÍÖÓÒÜÚÇ'\s]+$/i", trim($department))) {
        return personalizedErrors($namefield, '2');
    } elseif (strlen(trim($department)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($department)) > 45) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el domicilio
 * @param String $house variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valHouse($house, $namefield) {
    if (strlen(trim($house)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($house)) > 40) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el perfil de acceso
 * @param String $PA variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valProfileAccess($PA, $namefield) {
    if (strlen(trim($PA)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($PA)) > 9) {
        return personalizedErrors($namefield, '1');
    } elseif (trim($PA) != 'alumno' && trim($PA) != 'profesor' && trim($PA) != 'direccion') {//jefe de departamento 
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida si existe el sustituto
 * @global type $conn
 * @param String $sustitute variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valSustitute($sustitute, $namefield) {

    if ($sustitute != null) {
        global $conn;
        $query = "SELECT nombre FROM `profesores` WHERE codigo = '$sustitute';";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) == 0) {
            return personalizedErrors($namefield, '5');
        } elseif (strlen(trim($sustitute)) != 4) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return "Ok";
    }
}

/**
 * Valida si el profesor existe
 * @global type $conn
 * @param String $teacher variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valTeacher($teacher, $namefield) {

    if ($teacher != null) {
        global $conn;
        $teacher = substr($teacher, 0, 4);
        $query = "SELECT nombre FROM `profesores` WHERE codigo = '$teacher';";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) == 0) {
            return personalizedErrors($namefield, '5');
        } elseif (strlen(trim($teacher)) != 4) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return "Ok";
    }
}

/**
 * Valida el coordinador
 * @param String $coordinator variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valCoordinator($coordinator, $namefield) {
    if (strlen(trim($coordinator)) < 1) {
        return personalizedErrors($namefield, '0');
    } elseif (trim($coordinator) != '0' && trim($coordinator) != '1') {
        return personalizedErrors($namefield, '2');
    } elseif (strlen(trim($coordinator)) > 1) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el nombre de la actividad
 * @param String $EA variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valNameExtraActivity($EA, $namefield) {
    if (strlen(trim($EA)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($EA)) > 50) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el acompañante
 * @param String $coordination variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valCoordinationCompanion($coordination, $namefield) {//es dni, BASE DE DATOS
    $first = substr($dni, 0, 1);
    if ($first == "0" || $first == "X") {
        $aux = substr($dni, 1, 10);
        if (strlen($aux) != 9 || preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $aux, $matches) !== 1) {
            return personalizedErrors($namefield, '2');
        } else {
            return "Ok";
        }
    } else {
        return personalizedErrors($namefield, '2');
    }
}

/**
 * Valida los participantes
 * @param String $participant variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valParticipant($participant, $namefield) {
    if (strlen(trim($participant)) != 5) {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Valida el CLiteral
 * @param String $CL variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valCLITERAL($CL, $namefield) {
    if (strlen(trim($CL)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($CL)) > 30) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el VLiteral
 * @param String $VL variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valVLITERAL($VL, $namefield) {
    if (strlen(trim($VL)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($VL)) > 30) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida el DepCurt
 * @param String $DC variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valDepCurt($DC, $namefield) {
    if (strlen(trim($DC)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (strlen(trim($DC)) > 3) {
        return personalizedErrors($namefield, '1');
    } else {
        return "Ok";
    }
}

/**
 * Valida y comprueba el nombre del grupo
 * @global type $conn
 * @param String $GN variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valGroupName($GN, $namefield) {
    global $conn;
    $query = "SELECT nombre FROM grupos WHERE nombre = '$GN';";
    $result = $conn->query($query);

    if (strlen(trim($GN)) > 45) {
        return personalizedErrors($namefield, '1');
    } elseif (strlen(trim($GN)) == 0) {
        return personalizedErrors($namefield, '0');
    } elseif (mysqli_num_rows($result) == 0) {
        return personalizedErrors($namefield, '5');
    } else {
        return "Ok";
    }
}

/**
 * Valida el turno de horario
 * @param String $ST variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valScheduleTurn($ST, $namefield) {


    if ((strcmp($ST, "Mati") != 0) && (strcmp($ST, "Vesprada") != 0)) {
        return "Error en el campo: " . $namefield . ", dato no reconocido.";
    } else {
        return "Ok";
    }
}

/**
 * Valida el turno del alumno
 * @param String $Turn variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valTurn($Turn, $namefield) {
    if (strlen(trim($Turn)) != 1) {
        return personalizedErrors($namefield, '2');
    } elseif (strtoupper(trim($Turn)) != 'D' && strtoupper(trim($Turn)) != 'N' && strtoupper(trim($Turn)) != 'S') {
        return "Error en el campo: " . $namefield . ", dato no reconocido.";
    } else {
        return "Ok";
    }
}

/**
 * Valida si ha finalizado
 * @param String $finish variable que recibo
 * @param String $namefield nombre de donde viene
 * @return String devuelve el error u Ok
 */
function valFinish($finish, $namefield) {
    if (strlen(trim($finish)) != 1) {
        return personalizedErrors($namefield, '2');
    } else {
        return "Ok";
    }
}

/**
 * Sirve para personalizar los errores
 * @param String $from nombre del campo
 * @param String $case tipo de error
 * @return String devuelve el error personalizado
 */
function personalizedErrors($from, $case) {
    switch ($case) {
        case '0':
            return "Error en el campo: " . $from . ", se encuentra vacío.";
            break;
        case '1':
            return "Error en el campo: " . $from . ", ha excedido el tamaño máximo.";
            break;
        case '2':
            return "Error en el campo: " . $from . ", tiene un formato erróneo.";
            break;
        case '3':
            return "Error en el campo: " . $from . ", sólo se permiten números.";
            break;
        case '4':
            return "Error en el campo: " . $from . ", sólo se permiten letras.";
            break;
        case '5':
            return "Error en el campo: " . $from . ", no existe.";
            break;
    }
}

?>