<?php

session_start();
require_once "Classes/Class_DB.php";
$errors;
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
    header("Location:login.php");
} else {
    if ($_SESSION['userType'] == 'alumno') {
        $_SESSION['error'] = "No dispones de permisos suficientes para poder acceder a la administracion de usuarios";
        header("Location:controlPanel.php");
    }
}

include 'config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();
updateUser();

/**
 * Esta funcion se utilizará para validar los datos que nos lleguen del cliente.
 * @global type $errors Esta funcion utilizará la variable global errors.
 * @return type Esta funcion devolvera los errores que se encuentren en forma de array.
 */
function valData() {
    include 'Utils_Validations/Utils_Validation.php';
    global $errors;

    $email = valEmail($_POST['email'], "Email");
    if ($email != "Ok") {
        $errors[] = $email;
    }

    $email = valEmail($_POST['emailForAlumnos'], "Email alumnos");
    if ($email != "Ok") {
        $errors[] = $email;
    }

    $antiguapass = valPassword($_POST['oldPass'], "Contraseña antigua");
    if ($antiguapass != "Ok") {
        $errors[] = $antiguapass;
    }

    $pass = valPassword($_POST['newPass'], "Contraseña ");
    if ($pass != "Ok") {
        $errors[] = $pass;
    }
    return $errors;
}
/**
 * Esta funcion se utilizará para actualizar los datos del profesor.
 * @global type $conn
 */
function updateUser() {

    global $conn;
    if (count(valData()) == 0) {
        if (isset($_POST['newPass']) || $_POST['newPass'] != "") {
            $id = $_SESSION['userId'];
            $email = $_POST['email'];
            $oldPass = $_POST['oldPass'];
            $newPass = $_POST['newPass'];
            $photo = $_POST['foto'];
            $emailAlumnos = $_POST['emailForAlumnos'];


            if (checkOldPassword($oldPass)) {
                $query = "UPDATE profesores SET email= '$email',email_alumnos='$emailAlumnos', password='" . EncryptPassword($newPass) . "' where codigo=$id";
                $result = $conn->query($query);
                checkReport($result);
            } else {
                SendJSON('error', 'La contraseña vieja no coincide con la ya establecida. Revise y vuelva a intentarlo.');
            }
        } else {
            SendJSON('error', 'El campo contraseña no puede estar vacio. Revise y vuelva a intentarlo.');
        }
    } else {
        SendJSON("error", $errors);
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

function checkReport($result) {
    if ($result)
        SendJSON('ok', 'Los cambios se han guardado correctamente.');
    else
        SendJSON('error', 'Ha habido un error con la base de datos, vuelva a intentarlo mas tarde o contacte con el administrador del sistema.');
}
/**
 * Esta funcion se utilizará para comprobar que la contraseña vieja introducida sea correcta.
 * @global type $conn
 * @param type $password Este parametro recogerá la contraseña vieja.
 * @return boolean Este parametro devolverá un true si coincide o un false si no coincide.
 */
function checkOldPassword($password) {
    global $conn;
    $id = $_SESSION['userId'];
    $query = "select * from profesores where codigo=$id and password='" . EncryptPassword($password) . "'";
    $result = $conn->query($query);
    if ($result->num_rows != 0) {
        return true;
    } else {
        return false;
    }
}
/**
     * Esta funcion será utilizada para encriptar la contraseña.
     * @param type $password Esta variable recogera la contraseña del usuario.
     * @param type $digito Esta variable será utilizada para establecer el salt siempre el mismo.
     * @return type Esta función devolverá la contraseña encriptada.
     */
function EncryptPassword($password, $digito = 7) {
    $salt = sprintf('$2a$%02d$', $digito);
    $salt .= "1jd4jal9dmna3q941jdlc2";
    return crypt($password, $salt);
}

?>
